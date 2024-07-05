<?php

namespace Tests\Unit\Http\Requests\Backend\User;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Backend\User\UserListRequest;

class UserListRequestTest extends TestCase
{
    protected function getValidationRules(): array
    {
        $request = new UserListRequest();
        return $request->rules();
    }

    public function testValidationRules()
    {
        $rules = $this->getValidationRules();

        // Define the valid data
        $validData = [
            'search' => 'John Doe',
            'gender' => 'male',
            'limit'  => 10,
        ];

        $validator = Validator::make($validData, $rules);
        $this->assertTrue($validator->passes());

        // Define the invalid data
        $invalidDataSets = [
            ['gender' => 'not-a-gender'], // Invalid gender
            ['limit' => -1], // Invalid limit
            ['limit' => 'not-an-integer'], // Limit is not an integer
        ];

        foreach ($invalidDataSets as $invalidData) {
            $validator = Validator::make($invalidData, $rules);
            $this->assertFalse($validator->passes());
        }
    }

    public function testAuthorize()
    {
        $request = new UserListRequest();
        $this->assertTrue($request->authorize());
    }
}
