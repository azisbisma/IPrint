<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{

    public function saving(Product $product)
    {
        // Jika stok 0, maka status produk menjadi 'nonaktif'
        if ($product->stock == 0) {
            $product->status = 'nonaktif';
        } else {
            $product->status = 'aktif';
        }
    }

    /**
     * Handle the Product "updating" event.
     */
    public function updating(Product $product)
    {
        // Sama seperti pada event saving, cek stok sebelum update
        if ($product->stock == 0) {
            $product->status = 'nonaktif';
        } else {
            $product->status = 'aktif';
        }
    }
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
