<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EmployeeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * 一覧表示のテスト
     *
     * @group employee
     * @return void
     */
    public function testList()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->maximize()
                    ->visit('/')
                    ->waitForText('設定管理')
                    ->click('@setting')
                    ->waitForText('従業員')
                    ->click('@employee')
                    ->waitForText('従業員一覧')
                    ->waitUntilMissing('.loading-background', 10)
                    ->press('新規追加')
                    ->waitForText('従業員の新規作成')
                    ->waitUntilMissing('.loading-background', 10)
                    ->type('#last_name', '山田')
                    ->type('#first_name', '太郎')
                    ->type('#user_name', '000000')
                    ->type('#password', '123456')
                    ->press('登録する')
                    ->pause(1000)
                    ->assertDialogOpened('登録しました。')
                    ->acceptDialog()
                    ->waitForText('従業員一覧')
                    ->waitUntilMissing('.loading-background', 10)
                    ->visit('/employee/show/14')
                    ->waitUntilMissing('.loading-background', 10)
                    ->assertInputValue('#last_name', '山田')
                    ->assertInputValue('#first_name', '太郎')
                    ->assertInputValue('#user_name', '000000')
                    ->pause(1000)
                    ->press('戻る')
                    ->waitUntilMissing('.loading-background', 10)
                    ->visit('/employee/show/14')
                    ->waitUntilMissing('.loading-background', 10)
                    ->type("#last_name", 'MG')
                    ->type("#first_name", '花子')
                    ->type("#user_name", '000001')
                    ->pause(1000)
                    ->check('@is_admin')
                    ->press('保存する')
                    ->pause(1000)
                    ->assertDialogOpened('更新しました。')
                    ->acceptDialog()
                    ->waitUntilMissing('.loading-background', 10)
                    ->waitForText('従業員一覧')
                    ->visit('/employee/show/14')
                    ->waitUntilMissing('.loading-background', 10)
                    ->assertInputValue('#last_name', 'MG')
                    ->assertInputValue('#first_name', '花子')
                    ->assertInputValue('#user_name', '000001')
                    ->assertChecked('#is_admin')
                    ->press('戻る')
                    ->waitUntilMissing('.loading-background', 10)
                    ->visit('/employee/show/14')
                    ->waitUntilMissing('.loading-background', 10)
                    ->press('この従業員を削除する')
                    ->pause(1000)
                    ->assertDialogOpened('削除してもよろしいですか？')
                    ->acceptDialog()
                    ->pause(1000)
                    ->assertDialogOpened('削除しました。')
                    ->acceptDialog()
                    ->waitUntilMissing('.loading-background', 10)
                    ->waitForText('従業員一覧')
                    ->assertDontSee('MG花子')
                    // ->assertVue('value', '1988-11-21', '@0transfered_on')
                    // ->assertSelected("@0department_id", '1')
                    // ->assertSelected("@0section_id", '5')
                    // ->assertNotSelected("@0group_id", '')
                    // ->assertSelected("@0division_id", '8')
                    // ->screenshot('filename')
                    ;
        });
    }
}
