<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRenewalMailIncentiveToPurchasablesTable extends Migration
{
    public function up()
    {
        Schema::table('purchasables', function (Blueprint $table) {
            $table->text('renewal_mail_incentive')->nullable()->after('description');
        });
    }
}
