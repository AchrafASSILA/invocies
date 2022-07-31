<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50);
            $table->date('invoice_Date')->nullable();
            $table->date('Due_date')->nullable();
            $table->string('product', 50);
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('amount_collection', 8, 2)->nullable();
            $table->decimal('amount_borrowed', 8, 2)->nullable();
            $table->string('Status', 50)->default('غير مدفوعة');
            $table->integer('Value_Status')->default(2);
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
