<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVetOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vet_offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vet_id')->unsigned()->nullable();
            $table->foreign('vet_id')->references('id')->on('users')->onCascade('delete');
            $table->bigInteger('vet_request_id')->unsigned()->nullable();
            $table->foreign('vet_request_id')->references('id')->on('vet_requests')->onCascade('delete');
            $table->enum('status', ['PENDING', 'SKIPPED', 'ACCEPTED', 'COMPLETED'])->default('PENDING');
            $table->double('price', 8, 2)->default(0);
            $table->double('first_payment_price', 8, 2)->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vet_offers');
    }
}