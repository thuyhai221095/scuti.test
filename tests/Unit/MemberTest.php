<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\TblMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MemberTest extends TestCase
{
    use DatabaseMigrations;
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
            'infomation' => 'Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        // dd($response);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberName50Character()
    {
        $request = [
            'name' => str_random(51),
            'infomation' => 'Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        // dd($response);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberCanAlsoContain()
    {
        $request = [
            'name' => 'Thuy%',
            'infomation' => 'Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberInfomation300Character()
    {
        $request = [
            'name' => 'Thuy',
            'infomation' => str_random(301),
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberPhoneEmpty()
    {
        $request = [
            'name' => 'Thuy',
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
            'name' => 'Thuy',
            'infomation' => 'infomation',
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
            'name' => 'Thuy',
            'infomation' => 'infomation',
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
            'name' => 'Thuy',
            'infomation' => 'infomation',
            'phone' => '0984287619',
            'date_of_birth' => '',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberDateOfBirthValidationDate()
    {
        $request = [
            'name' => 'Thuy',
            'infomation' => 'infomation',
            'phone' => '0984287619',
            'date_of_birth' => 'abc',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberDateOfBirthInTheFuture()
    {
        $request = [
            'name' => 'Thuy',
            'infomation' => 'infomation',
            'phone' => '0984287619',
            'date_of_birth' => '2019-05-21',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberDateOfBirthOlderThan60Years()
    {
        $request = [
            'name' => 'Thuy',
            'infomation' => 'infomation',
            'phone' => '0984287619',
            'date_of_birth' => '1950-10-10',
            'position' => 'junior',
        ];
        $response = $this->call('POST', 'ajax/member', $request);
        $this->assertDatabaseMissing('tbl_members', $request);
    }

    public function testAddMemberPositionEmpty()
    {
        $request = [
            'name' => 'Thuy',
            'infomation' => 'infomation',
            'phone' => '0984287619',
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
        // test create member
        $request = [
            'name' => 'Thuy',
            'infomation' => 'Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
            'avatar' => $file
        ];
        $response = $this->json('POST', 'ajax/member', $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
            ]);
        $request['avatar'] = $file->hashName();
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testUpdateMemberSuccess()
    {
        // test update member
        $member = factory(TblMember::class)->create([
            'name' => 'Thuyhai22',
            'infomation' => 'infomation 01',
            'phone' => '0987654321',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ]);
        
        $request = [
            'name' => 'Thuy',
            'infomation' => 'Thuy',
            'phone' => '0984287637',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior',
        ];
        $response = $this->json('POST', '/ajax/updateMember/' . $member->id, $request);
        $response
            ->assertStatus(201)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseHas('tbl_members', $request);
    }

    public function testDeleteMember()
    {
        // test delete member
        $member = factory(TblMember::class)->create([
            'name' => 'Thuyhai22',
            'infomation' => 'infomation 01',
            'phone' => '0987654321',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior'
        ]);
        $response = $this->call('delete', 'ajax/member/'.$member->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'errors' => false
            ]);
        $this->assertDatabaseMissing('tbl_members', [
            'name' => 'Thuyhai22',
            'infomation' => 'infomation 01',
            'phone' => '0987654321',
            'date_of_birth' => '1995-10-22',
            'position' => 'junior'
        ]);
    }
}
