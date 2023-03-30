<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('profile_photo_path');
            $table->timestamp('otp_expiry')->nullable()->after('profile_photo_path');
            $table->string('email_token')->nullable()->after('profile_photo_path');
            $table->timestamp('account_locked_till')->nullable()->after('profile_photo_path');
            $table->string('application_domain')->nullable()->after('profile_photo_path');

            $table->string('timezone')->nullable()->after('profile_photo_path');
            $table->timestamp('date_of_birth')->nullable()->after('profile_photo_path');
            $table->timestamp('verified_at')->nullable()->after('profile_photo_path');
            $table->string('last_login_ip')->nullable()->after('profile_photo_path');
            $table->timestamp('last_login_at')->nullable()->after('profile_photo_path');
            $table->boolean('enforce_password_reset')->default(false)->after('email');
            $table->string('phone')->nullable()->after('email');
            $table->timestamp('phone_verified_at')->nullable()->after('email');
            $table->string('status')->default(User::STATUS_ACTIVE)->after('email')->comment(implode(', ', User::STATUSES));
            $table->string('role')->default(User::ROLE_USER)->after('password')->comment(implode(', ', User::ROLES));
            $table->string('first_name')->nullable()->after('password');
            $table->string('last_name')->nullable()->after('password');


            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->drop('verified_at');
            $table->drop('date_of_birth');
            $table->drop('last_login_at');
            $table->drop('last_login_ip');
            $table->drop('timezone');
            $table->drop('phone_verified_at');
            $table->drop('phone');
            $table->drop('status');
            $table->drop('first_name');
            $table->drop('last_name');
            $table->drop('role');
            $table->drop('otp');
            $table->drop('otp_expiry');
            $table->drop('email_token');
            $table->drop('account_locked_till');
            $table->drop('enforce_password_reset');
            $table->drop('application_domain');
        });
    }
};
