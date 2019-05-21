<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\TblMember;


class MemberTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    
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
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberDateOfBirthInTheFuture()
    {
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '098428761921',
            'date_of_birth' => '2019-05-21',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
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
        $this->assertDatabaseMissing('tbl_members', $request);
    }
    // Test Success
    public function testCreateMemberSuccess()
    {
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.png');
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '098428763733',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
            'avatar' => $file
        ];
        $response = $this->json('POST', 'ajax/member', $request);
        $request['avatar'] = $file->hashName();
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testUpdateMemberSuccess()
    {
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.png');
        $request = [
            'name' => 'Demo Test',
            'infomation' => 'Info Test',
            'phone' => '098428763722',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
            'avatar' => $file
        ];
        $response = $this->json('POST', '/ajax/updateMember/1', $request);
        $request['avatar'] = $file->hashName();
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testDeleteMember()
    {
        $response = $this->call('delete', 'ajax/member/1');
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseMissing('tbl_members', [
            'name' => 'Thuy',
            'infomation' => 'Infomation Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '22-10-1995',
            'position' => 'junior'
        ]);
    }
}
