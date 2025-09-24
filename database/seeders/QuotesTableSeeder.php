<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Quote;

class QuotesTableSeeder extends Seeder
{
    public function run()
    {
        $samples = [
            ['quote'=>"It is our choices, Harry, that show what we truly are, far more than our abilities.", 'author'=>'J.K. Rowling','book'=>'Harry Potter'],
            ['quote'=>"All we have to decide is what to do with the time that is given us.", 'author'=>'J.R.R. Tolkien','book'=>'The Fellowship of the Ring'],
            ['quote'=>"So we beat on, boats against the current, borne back ceaselessly into the past.", 'author'=>'F. Scott Fitzgerald','book'=>'The Great Gatsby'],
            ['quote'=>"It does not do to dwell on dreams and forget to live.", 'author'=>'J.K. Rowling','book'=>'Harry Potter'],
            ['quote'=>"Not all those who wander are lost.", 'author'=>'J.R.R. Tolkien','book'=>'The Lord of the Rings'],
        ];
        foreach ($samples as $q) Quote::create($q);
    }
}
