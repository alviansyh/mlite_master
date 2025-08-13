<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'document_number',
        'reference',
        'date',
        'notes',
        'source_warehouse_id',
        'destination_warehouse_id',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
            $model->updateInventory();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
            $model->updateInventory();
        });

        static::deleting(function ($model) {
            $model->revertInventory();
        });
    }

    public function sourceWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'source_warehouse_id');
    }

    public function destinationWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // Metode untuk memperbarui inventaris
    public function updateInventory()
    {
        foreach ($this->items as $item) {
            // Perbarui stok di gudang tujuan untuk transaksi 'in'
            if ($this->type === 'in') {
                $inventory = Inventory::firstOrNew([
                    'material_id'  => $item->material_id,
                    'warehouse_id' => $this->destination_warehouse_id,
                    'batch_number' => $item->batch_number,
                ]);

                if ($inventory->exists) {
                    $inventory->quantity += $item->quantity;
                    $inventory->save();
                } else {
                    $inventory->fill([
                        'expired_at' => $item->expired_at,
                        'quantity'   => $item->quantity,
                        'unit_code'  => $item->unit_code,
                    ])->save();
                }
            }

            // Kurangi stok di gudang asal untuk transaksi 'out'
            if ($this->type === 'out') {
                // Logika pengurangan stok (FEFO/FIFO)
                // Contoh sederhana: Kurangi dari stok yang ditemukan
                $inventory = Inventory::where('material_id', $item->material_id)
                    ->where('warehouse_id', $this->source_warehouse_id)
                    ->where('batch_number', $item->batch_number)
                    ->first();

                if ($inventory) {
                    $inventory->quantity -= $item->quantity;
                    if ($inventory->quantity <= 0) {
                        $inventory->delete();
                    } else {
                        $inventory->save();
                    }
                }
            }
        }
    }

    // Metode untuk mengembalikan stok saat transaksi dihapus
    public function revertInventory()
    {
        foreach ($this->items as $item) {
            // Jika transaksi dihapus, kembalikan stok
            if ($this->type == 1) {
                // Kurangi stok yang sebelumnya ditambahkan
                $inventory = Inventory::where('material_id', $item->material_id)
                    ->where('warehouse_id', $this->destination_warehouse_id)
                    ->where('batch_number', $item->batch_number)
                    ->first();
                if ($inventory) {
                    $inventory->quantity -= $item->quantity;
                    if ($inventory->quantity <= 0) {
                        $inventory->delete();
                    } else {
                        $inventory->save();
                    }
                }
            }

            // Jika transaksi keluar dihapus, kembalikan stok
            if ($this->type == 2) {
                // Tambah stok yang sebelumnya dikurangi
                $inventory = Inventory::firstOrNew([
                    'material_id'  => $item->material_id,
                    'warehouse_id' => $this->source_warehouse_id,
                    'batch_number' => $item->batch_number,
                ]);

                if ($inventory->exists) {
                    $inventory->quantity += $item->quantity;
                    $inventory->save();
                } else {
                    $inventory->fill([
                        'expired_at' => $item->expired_at,
                        'quantity'   => $item->quantity,
                        'unit_code'  => $item->unit_code,
                    ])->save();
                }
            }
        }
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
