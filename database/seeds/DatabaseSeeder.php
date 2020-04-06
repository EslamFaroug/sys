<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            'name' => "eslam",
            "email" => "eslam@web.com",
            "password" => bcrypt("eslam"),
        ]);

        DB::table("roles")->insert([
            'name' => "admin",
            "description" => "admin",
        ]);

        DB::table("roles")->insert([
            'name' => "teacher",
            "description" => "teacher",
        ]);

        DB::table("roles")->insert([
            'name' => "user",
            "description" => "user",
        ]);

        DB::table("user_role")->insert([
            'user_id' => "1",
            "role_id" => "1",
        ]);

        DB::table("counteries")->insert([
            'name' => "السودان",
            "symbole" => "SDN",
        ]);

        DB::table("states")->insert([
            'name' => "الخرطوم",
            "countery_id" => "1",
        ]);

        DB::table("regionals")->insert([
            'name' => "امدرمان",
            "state_id" => "1",
        ]);

        DB::table("units")->insert([
            'name' => "كرري شمال",
            "regional_id" => "1",
        ]);

        DB::table("types")->insert([
            'name' => "حكومي",
        ]);

        DB::table("types")->insert([
            'name' => "خاص",
        ]);

        DB::table("types")->insert([
            'name' => "اهلي",
        ]);


        DB::table("universities")->insert([
            'name' => "جامعة الخرطوم",
            'type_id'=> "1",
            "countery_id"=> "1"
        ]);


        DB::table("universities")->insert([
            'name' => "جامعة السودان للعلوم والتكنولوجيا",
            'type_id'=> "1",
            "countery_id"=> "1"
        ]);

        DB::table("universities")->insert([
            'name' => "جامعة النيلين",
            'type_id'=> "1",
            "countery_id"=> "1"
        ]);

        DB::table("colleges")->insert([
            'name' => "كلية الطب",
            'university_id'=> "1",
        ]);


        DB::table("colleges")->insert([
            'name' => "كلية العلوم",
            'university_id'=> "2",
        ]);


        DB::table("colleges")->insert([
            'name' => "كلية علوم الحاسوب وتقانة المعلومات",
            'university_id'=> "3",
        ]);

        DB::table("departments")->insert([
            'name' => "قسم نظم معلومات المكتبات",
            'college_id'=> "3",
        ]);

        DB::table("departments")->insert([
            'name' => "قسم تقانة المعلومات",
            'college_id'=> "3",
        ]);


        DB::table("degrees")->insert([
            'name' => "مساعد تدريس",
        ]);
        DB::table("degrees")->insert([
            'name' => "محاضر",
        ]);
        DB::table("degrees")->insert([
            'name' => "إستاذ",
        ]);

        DB::table("degrees")->insert([
            'name' => "إستاذ مشارك",
        ]);

        DB::table("degrees")->insert([
            'name' => "بروفيسور",
        ]);

        DB::table("work_types")->insert([
            'name' => "تعيين",
        ]);

        DB::table("work_types")->insert([
            'name' => "تعاقد",
        ]);

        DB::table("study_types")->insert([
            'name' => "نظامي",
        ]);
        DB::table("study_types")->insert([
            'name' => "عن بعد",
        ]);


        DB::table("specials")->insert([
            'name' => "أمن  معلومات",
            "special_type"=>"تخصص  عام",
            "depart_id"=>"2"
        ]);


        DB::table("specials")->insert([
            'name' => "مطور ويب",
            "special_type"=>"تخصص  عام",
            "depart_id"=>"2"
        ]);

        DB::table("specials")->insert([
            'name' => "مطور Laravel",
            "special_type"=>"تخصص  خاص",
            "depart_id"=>"2"
        ]);

        DB::table("qualifications")->insert([
            'name' => "جامعي",
        ]);
        DB::table("qualifications")->insert([
            'name' => "فوق الجامعي",
        ]);
        DB::table("qualifications")->insert([
            'name' => "مهني",
        ]);


        DB::table("mangejobs")->insert([
            'name' => "رئيس قسم",
        ]);
        DB::table("mangejobs")->insert([
            'name' => "رئيس شعبة",
        ]);

        DB::table("teachers")->insert([
            'ar_name' => "إسلام فاروق يوسفُ",
            'en_name' => "ُEslam Faroug Yousef",
            'card_id' => "1172354652",
            'dob' => "1995/5/20",
            'pob' => "ليبيا",
            'gender' => "1",
            'status' => "1",
            'mother_tounge' => "1",
            'countery_id' => "1",
            'degree_id' => "1",
            'user_id' => "1",
        ]);

        DB::table("contacts")->insert([
            'teacher_id' => "1",
            'email' => "eslam@web.com",
        ]);


    }
}
