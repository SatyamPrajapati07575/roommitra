<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Facades\DB;

class StatesCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->delete();
        DB::table('states')->delete();

        $statesWithCities = [
            'Uttar Pradesh' => [
                'Lucknow', 'Kanpur', 'Agra', 'Varanasi', 'Meerut', 'Ghaziabad', 'Noida', 
                'Prayagraj', 'Bareilly', 'Aligarh', 'Moradabad', 'Saharanpur', 'Gorakhpur',
                'Mathura', 'Firozabad', 'Jhansi', 'Muzaffarnagar', 'Rampur', 'Shahjahanpur'
            ],
            'Maharashtra' => [
                'Mumbai', 'Pune', 'Nagpur', 'Nashik', 'Thane', 'Aurangabad', 'Solapur',
                'Kolhapur', 'Amravati', 'Nanded', 'Sangli', 'Jalgaon', 'Akola', 'Latur',
                'Dhule', 'Ahmednagar', 'Chandrapur', 'Parbhani', 'Ichalkaranji'
            ],
            'Bihar' => [
                'Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Purnia', 'Darbhanga', 
                'Arrah', 'Begusarai', 'Katihar', 'Munger', 'Chhapra', 'Danapur', 
                'Bettiah', 'Saharsa', 'Hajipur', 'Sasaram', 'Dehri', 'Siwan'
            ],
            'West Bengal' => [
                'Kolkata', 'Howrah', 'Durgapur', 'Asansol', 'Siliguri', 'Bardhaman', 
                'Malda', 'Baharampur', 'Habra', 'Kharagpur', 'Shantipur', 'Dankuni', 
                'Dhulian', 'Ranaghat', 'Haldia', 'Raiganj', 'Krishnanagar'
            ],
            'Madhya Pradesh' => [
                'Indore', 'Bhopal', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar', 'Dewas',
                'Satna', 'Ratlam', 'Rewa', 'Murwara', 'Singrauli', 'Burhanpur', 'Khandwa',
                'Bhind', 'Chhindwara', 'Guna', 'Shivpuri', 'Vidisha'
            ],
            'Tamil Nadu' => [
                'Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli',
                'Tiruppur', 'Ranipet', 'Nagercoil', 'Thanjavur', 'Vellore', 'Kancheepuram',
                'Erode', 'Tiruvannamalai', 'Pollachi', 'Rajapalayam', 'Sivakasi'
            ],
            'Rajasthan' => [
                'Jaipur', 'Jodhpur', 'Kota', 'Bikaner', 'Udaipur', 'Ajmer', 'Bhilwara',
                'Alwar', 'Bharatpur', 'Pali', 'Barmer', 'Sikar', 'Tonk', 'Sadulpur',
                'Sawai Madhopur', 'Jetpur', 'Hanumangarh', 'Gangapur City', 'Churu'
            ],
            'Karnataka' => [
                'Bangalore', 'Mysore', 'Hubli', 'Mangalore', 'Belgaum', 'Gulbarga',
                'Davanagere', 'Bellary', 'Bijapur', 'Shimoga', 'Tumkur', 'Raichur',
                'Bidar', 'Hospet', 'Gadag-Betigeri', 'Robertsonpet', 'Hassan'
            ],
            'Gujarat' => [
                'Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar',
                'Junagadh', 'Gandhidham', 'Nadiad', 'Morbi', 'Surendranagar', 'Bharuch',
                'Vapi', 'Navsari', 'Veraval', 'Porbandar', 'Godhra', 'Bhuj', 'Anand'
            ],
            'Andhra Pradesh' => [
                'Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool', 'Rajahmundry',
                'Kakinada', 'Tirupati', 'Anantapur', 'Kadapa', 'Vizianagaram', 'Eluru',
                'Ongole', 'Nandyal', 'Machilipatnam', 'Adoni', 'Tenali', 'Proddatur'
            ],
            'Telangana' => [
                'Hyderabad', 'Warangal', 'Nizamabad', 'Khammam', 'Karimnagar', 'Ramagundam',
                'Mahbubnagar', 'Nalgonda', 'Adilabad', 'Suryapet', 'Siddipet', 'Miryalaguda',
                'Jagtial', 'Mancherial', 'Nirmal', 'Kothagudem', 'Bodhan'
            ],
            'Odisha' => [
                'Bhubaneswar', 'Cuttack', 'Rourkela', 'Brahmapur', 'Sambalpur', 'Puri',
                'Balasore', 'Bhadrak', 'Baripada', 'Jharsuguda', 'Jeypore', 'Bargarh',
                'Rayagada', 'Balangir', 'Bhawanipatna', 'Dhenkanal', 'Barbil'
            ],
            'Kerala' => [
                'Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Kollam', 'Thrissur', 'Kannur',
                'Alappuzha', 'Kottayam', 'Palakkad', 'Malappuram', 'Manjeri', 'Thalassery',
                'Ponnani', 'Vatakara', 'Kanhangad', 'Payyanur', 'Koyilandy'
            ],
            'Punjab' => [
                'Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Mohali',
                'Pathankot', 'Hoshiarpur', 'Batala', 'Moga', 'Malerkotla', 'Khanna',
                'Phagwara', 'Muktsar', 'Barnala', 'Firozpur', 'Kapurthala', 'Zirakpur'
            ],
            'Haryana' => [
                'Faridabad', 'Gurgaon', 'Panipat', 'Ambala', 'Yamunanagar', 'Rohtak',
                'Hisar', 'Karnal', 'Sonipat', 'Panchkula', 'Bhiwani', 'Sirsa',
                'Bahadurgarh', 'Jind', 'Thanesar', 'Kaithal', 'Rewari', 'Palwal'
            ],
            'Jharkhand' => [
                'Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Deoghar', 'Phusro',
                'Hazaribagh', 'Giridih', 'Ramgarh', 'Medininagar', 'Chirkunda'
            ],
            'Assam' => [
                'Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon', 'Tinsukia',
                'Tezpur', 'Bongaigaon', 'Dhubri', 'Diphu', 'Goalpara', 'Barpeta'
            ],
            'Chhattisgarh' => [
                'Raipur', 'Bhilai', 'Bilaspur', 'Korba', 'Durg', 'Rajnandgaon',
                'Jagdalpur', 'Raigarh', 'Ambikapur', 'Mahasamund', 'Dhamtari'
            ],
            'Uttarakhand' => [
                'Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rudrapur', 'Kashipur',
                'Rishikesh', 'Mussoorie', 'Nainital', 'Almora', 'Pithoragarh'
            ],
            'Himachal Pradesh' => [
                'Shimla', 'Mandi', 'Solan', 'Nahan', 'Sundernagar', 'Palampur',
                'Kullu', 'Hamirpur', 'Una', 'Dharamshala', 'Baddi', 'Kangra'
            ],
            'Jammu and Kashmir' => [
                'Srinagar', 'Jammu', 'Anantnag', 'Baramulla', 'Sopore', 'Kathua',
                'Udhampur', 'Punch', 'Rajauri'
            ],
            'Delhi' => [
                'New Delhi', 'North Delhi', 'South Delhi', 'East Delhi', 'West Delhi',
                'Central Delhi', 'Shahdara', 'Rohini', 'Dwarka', 'Najafgarh'
            ],
            'Goa' => [
                'Panaji', 'Margao', 'Vasco da Gama', 'Mapusa', 'Ponda', 'Mormugao'
            ],
            'Puducherry' => [
                'Puducherry', 'Karaikal', 'Mahe', 'Yanam'
            ],
            'Chandigarh' => [
                'Chandigarh'
            ],
        ];

        foreach ($statesWithCities as $stateName => $cities) {
            $state = State::create([
                'state_name' => $stateName,
                'is_active' => true,
            ]);

            foreach ($cities as $cityName) {
                City::create([
                    'state_id' => $state->state_id,
                    'city_name' => $cityName,
                    'is_active' => true,
                ]);
            }
        }

        echo "✅ States and Cities seeded successfully!\n";
        echo "📍 Total States: " . State::count() . "\n";
        echo "🏙️  Total Cities: " . City::count() . "\n";
    }
}
