<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id'); // document id
            $table->unsignedBigInteger('borrower_id'); // yang minjem
            $table->unsignedBigInteger('owner_id'); // yang punya
            $table->boolean('is_borrowed');
            $table->unsignedTinyInteger('return_status');
            $table->timestamps();

            // pasang foreign key
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('borrower_id')->references('id')->on('users');
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // lepas foreign key
        Schema::table('borrowers', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['borrower_id']);
            $table->dropForeign(['owner_id']);
        });

        Schema::dropIfExists('borrowers');
    }
}
