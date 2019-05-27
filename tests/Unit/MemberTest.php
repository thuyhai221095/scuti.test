<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\TblMember;

class MemberTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    // Test Success
    public function testCreateMemberSuccess()
    {
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.png');
        $request = [
            'name' => 'Thuy',
            'infomation' => 'Info Test',
            'phone' => '098428763733',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
            'avatar' => $file
        ];
        $response = $this->json('POST', 'ajax/member', $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false,
                'msg' => 'Add new successfully'
            ]);
        $request['avatar'] = $file->hashName();
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testUpdateMemberSuccess()
    {
        $member = factory(TblMember::class)->create();
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.png');
        $request = [
            'name' => 'Thuy',
            'infomation' => 'Info Test',
            'phone' => '098428763722',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
            'avatar' => $file
        ];
        $response = $this->json('POST', '/ajax/updateMember/'.$member->id, $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false,
                'msg' => 'Update successfully'
            ]);
        $request['avatar'] = $file->hashName();
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testDeleteMember()
    {
        $member = factory(TblMember::class)->create();
        $response = $this->call('delete', 'ajax/member/'.$member->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false,
                'msg' => 'Delete successfully'
            ]);
    }
    // Test Failed
    public function testAddMemberNameEmpty()
    {
        $request = [
            'name' => '',
            'infomation' => 'Info Test',
            'phone' => '098428763733',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'name' => [
                        0 => 'The name field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberName50Character()
    {
        $request = [
            'name' => str_random(51),
            'infomation' => 'Info Test',
            'phone' => '098428763737',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'name' => [
                        0 => 'The name may not be greater than 50 characters.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberCanAlsoContain()
    {
        $request = [
            'name' => 'Thuy%',
            'infomation' => 'Thuy',
            'phone' => '098428763765',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'name' => [
                        0 => 'The name format is invalid.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberInfomation300Character()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => str_random(301),
            'phone' => '098428763251',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'infomation' => [
                        0 => 'The infomation may not be greater than 300 characters.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberPhoneEmpty()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'infomation',
            'phone' => '',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'phone' => [
                        0 => 'The phone field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberPhone20Character()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'info test',
            'phone' => '098425786321452032151',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'phone' => [
                        0 => 'The phone may not be greater than 20 characters.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberPhoneNumeric()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '0984287619a',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'phone' => [
                        0 => 'The phone format is invalid.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }
    
    public function testAddMemberDateOfBirthEmpty()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '098428761902',
            'date_of_birth' => '',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'date_of_birth' => [
                        0 => 'The date of birth field is required.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberDateOfBirthValidationDate()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '098428761911',
            'date_of_birth' => 'abc',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'date_of_birth' => [
                        0 => 'The date of birth is not a valid date.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberDateOfBirthInTheFuture()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '098428761921',
            'date_of_birth' => '2020-10-10',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'date_of_birth' => [
                        0 => 'The date of birth must be a date before or equal to now.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberDateOfBirthOlderThan60Years()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '0984287619333',
            'date_of_birth' => '1950-10-10',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'date_of_birth' => [
                        0 => 'The date of birth must be a date after -60 years.'
                    ]
                ]
            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberPositionEmpty()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '098428761944',
            'date_of_birth' => '1995-10-10',
            'position' => '',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $response
            ->assertJson([
                'errors' => true,
                'status' => 422,
                'msg' => [
                    'position' => [
                        0 => 'The position field is required.'
                    ]
                ]

            ]);
        $this->assertDatabaseMissing('tbl_members', $request);
    }
}
