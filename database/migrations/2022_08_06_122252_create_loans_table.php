<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('RESTRICT');
            $table->integer('tenure');
            $table->decimal('amount', 8, 2);
            $table->date('loan_request_date');
            $table->tinyInteger('is_loan_approved')->default('0'); // Zero for pending
            $table->tinyInteger('is_loan_paid')->default('0'); // Zero for pending
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
        Schema::dropIfExists('loans');
    }
}
