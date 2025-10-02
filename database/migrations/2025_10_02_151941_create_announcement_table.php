<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\AnnouncementTypeEnum;
use App\Enums\AnnouncementStatusEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->boolean('active')->default(false);
            $table->enum('type', array_column(AnnouncementTypeEnum::cases(), 'value'));
            $table->enum('status', array_column(AnnouncementStatusEnum::cases(), 'value'));
            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
