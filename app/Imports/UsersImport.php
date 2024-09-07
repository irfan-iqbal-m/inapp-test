<?php

namespace App\Imports;

use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class UsersImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $collection)
    {
        // Validate headers
        $headers = $collection->first()->keys()->toArray();
        $requiredHeaders = ['firstname', 'lastname', 'email', 'phone', 'doj', 'designation'];

        if (array_diff($requiredHeaders, $headers)) {
            throw new \Exception('CSV headers are not in the correct format.');
        }

        // Import data
        foreach ($collection as $row) {
            if (!User::where('email', $row['email'])->exists()) {

                $obj = new User();
                $obj->name = $row['firstname'];
                $obj->lastname = $row['lastname'];
                $obj->email = $row['email'];
                $obj->password = Hash::make('admin123');
                $obj->phone = $row['phone'];
                $obj->designation = $row['designation'];
                $obj->doj = \Carbon\Carbon::parse($row['doj']);
                $obj->save();
                Mail::to('g.support@lightflow.it')->locale('it')->send(new UserMail());
            }
        }
    }
}
