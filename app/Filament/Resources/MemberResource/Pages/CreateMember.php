<?php

namespace App\Filament\Resources\MemberResource\Pages;

use Filament\Actions;
use App\Helper\Helper;
use App\Models\Member;
use App\Models\WaNotif;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\MemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $pwd = Helper::passwordGenerator(8);
        $data['password'] = Hash::make($pwd);
        $data['status'] = 'active';
        $data['point'] = 0;
        $data['image'] = 'https://ui-avatars.com/api/?name='.urlencode($data['username']);
        $data['qrcode'] =null;

        return $data;
    }

    protected function afterCreate(): void
    {
        $qr = new QRCode();
        $id_member  = $this->record->getKey();
        $pwd = Helper::passwordGenerator(8);
        $qr->render(base64_encode($id_member));
        $member = Member::find($id_member);
        $member->qrcode = $qr->render(base64_encode($id_member));
        $member->password = Hash::make($pwd);
        $member->save();


        $notifWa = WaNotif::where('type', 'register')->first();
        
        $message = Helper::replacer($notifWa->message, ['password' => $pwd, 
                'email' => $member->email , 
                'username' => $member->username , 
                'name' => $member->username
            ]);
        $response = Helper::sendWhatsappMessage($member->phone,$message);
    }

}
