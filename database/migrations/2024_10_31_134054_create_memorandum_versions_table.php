<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemorandumVersionsTable extends Migration
{
    public function up()
    {
        Schema::create('memorandum_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorandum_id')->constrained('memorandums')->onDelete('cascade');
            $table->unsignedBigInteger('edited_by');       // The user who made the edit
            $table->decimal('version', 3, 1);              // Version number
            $table->timestamps();                          // Timestamps for the version
            $table->date('valid_until')->nullable();
            //Original Content of the Memorandum Table
            $table->longText('partnership_title');
            $table->string('validity_period');
            $table->json('whereas_clauses')->nullable();
            $table->json('article_1')->nullable();
            $table->json('article_2_AUF')->nullable()->default(json_encode([
                "It is a duly organized educational corporation under the laws of the Republic of the Philippines.",
                "It is a recognized institution of higher learning duly authorized by the regulatory authorities of the Republic of the Philippines to offer degree and post­ degree programs and to carry on its business as it is being conducted.",
                "It has qualified faculty members to teach the academic programs covered by this MOA.",
                "It has sufficient number of personnel who shall ensure the smooth implementation of this MOA.",
                "It has the necessary educational facilities and learning resources suitable for the academic programs to be offered pursuant to this MOA.",
                "Its entry into and performance, and the transactions contemplated by, this MOA do not and will not conflict with: (i) any law applicable to the AUF; (ii) its constitutional documents; or (iii) any agreement or instrument binding upon it or any of its assets.",
                "The signatory to this MOA is duly authorized by its governing Board to validly enter into this MOA.",
            ]));
            $table->json('article_2_partner')->nullable();
            $table->json('article_3')->nullable();
            $table->json('article_4')->nullable();
            $table->json('article_5')->nullable();
            $table->json('article_6')->nullable();
            $table->json('article_7')->nullable();
            $table->json('article_8')->nullable();
            $table->json('article_9')->nullable();
            $table->json('article_10')->nullable();
            $table->json('article_11')->nullable();
            $table->json('article_12')->nullable();
            $table->json('article_13')->nullable();
            $table->json('article_14')->nullable();
            $table->json('article_15')->nullable();
            $table->json('article_16')->nullable();
            $table->json('article_17')->nullable();
            $table->json('article_18')->nullable();
            $table->json('article_19')->nullable();
            $table->json('article_20')->nullable();
            $table->json('article_21')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('memorandum_versions');
    }
}
