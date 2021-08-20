<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     * 
     * 
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('email');
            $table->string('ddd_phone')->nullable();
            $table->string('phone')->nullable();
            $table->string('ddd_mobile')->nullable();
            $table->string('mobile')->nullable();
            $table->string('name');
            $table->string('cpf')->nullable();
            $table->string('pis')->nullable();
            $table->string('rg')->nullable();
            $table->string('rg_emitter')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_district')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('natural_city')->nullable();
            $table->string('natural_state')->nullable();
            $table->string('natural_country')->nullable();
            $table->string('civil_state')->nullable();
            $table->string('gender')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('housing')->nullable();
            $table->integer('children_amount')->nullable();
            $table->string('children_age')->nullable();
            $table->string('children_location')->nullable();
            $table->string('father_name')->nullable();
            $table->date('father_dob')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('mother_dob')->nullable();
            $table->integer('foreigner')->nullable();
            $table->integer('deficiency')->nullable();
            $table->integer('deficiency_id')->nullable();
            $table->date('arrival_date')->nullable();            
            $table->string('foreign_register')->nullable();
            $table->string('foreign_emitter')->nullable();
            $table->date('visa_expiration')->nullable();
            $table->string('work_card')->nullable();
            $table->string('work_card_series')->nullable();
            $table->string('work_card_digit')->nullable();
            $table->string('elector_card')->nullable();
            $table->string('veteran_card')->nullable();
            $table->string('serie')->nullable();
            $table->string('cid')->nullable();
            $table->string('zip',10)->nullable();
            $table->string('cv')->nullable();
            $table->text('skills')->nullable();
            $table->text('others')->nullable();
            $table->date('dob')->nullable();
            $table->datetime('last_seen')->nullable();
            $table->integer('worked_earlier_at_lunelli')->nullable();
            $table->date('lunelli_earlier_work_period_start')->nullable();
            $table->date('lunelli_earlier_work_period_end')->nullable();
            $table->string('time_living_in_sc')->nullable();
            $table->string('cities_lived_before')->nullable();
            $table->string('living_with')->nullable();
            $table->string('living_with_professions')->nullable();
            $table->string('spouse_job')->nullable();
            $table->string('work_commute')->nullable();
            $table->date('last_time_doctor')->nullable();
            $table->string('last_time_doctor_reason')->nullable();
            $table->integer('surgery')->nullable();
            $table->string('surgery_reason')->nullable();
            $table->integer('hospitalized')->nullable();
            $table->string('hospitalized_reason')->nullable();
            $table->integer('work_accident')->nullable();
            $table->string('work_accident_where')->nullable();
            $table->string('positive_personal_characteristics')->nullable();
            $table->string('personal_aspects_for_betterment')->nullable();
            $table->string('lunelli_family')->nullable();
            $table->string('pretended_salary')->nullable();
            $table->integer('worked_without_ctp')->nullable();
            $table->string('worked_without_ctp_job')->nullable();
            $table->string('worked_without_ctp_how_long')->nullable();
            $table->integer('previous_work_legal_action')->nullable();
            $table->string('previous_work_legal_action_business')->nullable();
            $table->string('previous_work_legal_action_reason')->nullable();
            $table->string('professional_dream')->nullable();
            $table->string('personal_dream')->nullable();
            $table->text('who_are_you')->nullable();
            $table->string('professional_motivation')->nullable();
            $table->string('what_irritates_you')->nullable();
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
        Schema::dropIfExists('candidates');
    }
}
