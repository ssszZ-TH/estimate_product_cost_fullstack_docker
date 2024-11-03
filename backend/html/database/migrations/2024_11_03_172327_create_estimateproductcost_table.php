<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('estimateproductcost', function (Blueprint $table) {
        $table->integer('id')->primary();
        $table->string('code', 20)->unique();
        $table->date('fromdate');
        $table->date('thrudate')->nullable();
        $table->integer('cost');
        
        // Foreign keys
        $table->integer('costtypeid')->nullable();
        $table->foreign('costtypeid')->references('id')->on('costtype')->onDelete('set null');

        $table->integer('geographicboundaryid')->nullable();
        $table->foreign('geographicboundaryid')->references('id')->on('geographicboundary')->onDelete('set null');

        $table->string('supplierid', 20)->nullable();
        $table->foreign('supplierid')->references('id')->on('supplier')->onDelete('set null');

        $table->integer('productfeatureid')->nullable();
        $table->foreign('productfeatureid')->references('id')->on('productfeature')->onDelete('set null');

        $table->integer('productid')->nullable();
        $table->foreign('productid')->references('id')->on('product')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimateproductcost');
    }
};
