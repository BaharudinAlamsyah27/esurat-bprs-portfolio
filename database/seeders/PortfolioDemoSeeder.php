<?php

namespace Database\Seeders;

use App\Enums\DispositionInstruction;
use App\Enums\DispositionNature;
use App\Enums\DispositionRecipientStatus;
use App\Enums\UserLevel;
use App\Models\Classification;
use App\Models\CooperationAgreement;
use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\Institution;
use App\Models\LetterSequence;
use App\Models\OutgoingLetter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PortfolioDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Instansi Demo (100% fiktif untuk portofolio)
        Institution::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => 'PT BPRS Sragen (Demo Portofolio)',
                'address' => 'Jl. Raya Sukowati No. 123, Sragen, Jawa Tengah',
                'phone' => '(0271) 891-000',
                'email' => 'sekretariat@demo-bprssragen.test',
                'city' => 'Sragen',
                'leader_name' => 'H. Ahmad Fauzi, S.E., M.M.',
                'leader_position' => 'Direktur Utama',
            ],
        );

        // 2. Akun Demo 3 Role (Superadmin, Admin Persuratan, Pegawai)
        $superadmin = User::query()->updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Rizky Pratama (Superadmin)',
                'position_title' => 'Kepala Divisi IT',
                'email' => 'superadmin@demo-esurat.test',
                'level' => UserLevel::SuperAdmin,
                'is_active' => true,
                'push_enabled' => true,
                'password' => 'DemoEsurat123',
            ],
        );

        $admin = User::query()->updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Siti Aminah (Admin Persuratan)',
                'position_title' => 'Sekretaris Direksi',
                'email' => 'admin@demo-esurat.test',
                'level' => UserLevel::Admin,
                'is_active' => true,
                'push_enabled' => true,
                'password' => 'DemoEsurat123',
            ],
        );

        $pegawai = User::query()->updateOrCreate(
            ['username' => 'pegawai'],
            [
                'name' => 'Budi Santoso (Pegawai)',
                'position_title' => 'Staf Operasional & Pembiayaan',
                'email' => 'pegawai@demo-esurat.test',
                'level' => UserLevel::User,
                'is_active' => true,
                'push_enabled' => true,
                'password' => 'DemoEsurat123',
            ],
        );

        $pegawai2 = User::query()->updateOrCreate(
            ['username' => 'dewi'],
            [
                'name' => 'Dewi Kartika',
                'position_title' => 'Analis Kepatuhan & Audit',
                'email' => 'dewi@demo-esurat.test',
                'level' => UserLevel::User,
                'is_active' => true,
                'push_enabled' => true,
                'password' => 'DemoEsurat123',
            ],
        );

        $classifications = Classification::query()->get()->keyBy('code');
        $year = (int) now()->year;

        // 3. Surat Masuk Fiktif (tersebar di 6 bulan terakhir agar grafik terlihat hidup)
        $incomingSamples = [
            ['code' => '700', 'months_ago' => 5, 'day' => 8, 'number' => 'S-112/KR.03/OJK/2026', 'sender' => 'OJK Kantor Regional 3 Jateng & DIY', 'subject' => 'Penyampaian Laporan Pengawasan Berkala Triwulan I', 'dispose' => true, 'done' => true],
            ['code' => '900', 'months_ago' => 4, 'day' => 14, 'number' => '045/BI-SLO/KEU/2026', 'sender' => 'Bank Indonesia KPw Solo', 'subject' => 'Undangan Sosialisasi Sistem Pembayaran & QRIS Syariah', 'dispose' => true, 'done' => true],
            ['code' => '500', 'months_ago' => 3, 'day' => 6, 'number' => '089/KOP-MAJU/2026', 'sender' => 'Koperasi Karyawan Sejahtera Sragen', 'subject' => 'Permohonan Penawaran Kerjasama Pembiayaan Mikro', 'dispose' => true, 'done' => true],
            ['code' => '300', 'months_ago' => 3, 'day' => 21, 'number' => '005/1420/PEMKAB-SRG/2026', 'sender' => 'Pemerintah Kabupaten Sragen', 'subject' => 'Undangan Rapat Koordinasi BUMD Semester I', 'dispose' => true, 'done' => false],
            ['code' => '100', 'months_ago' => 2, 'day' => 10, 'number' => '210/ASBISINDO-JTG/2026', 'sender' => 'ASBISINDO Jawa Tengah', 'subject' => 'Pemberitahuan Pelatihan Tata Kelola Perbankan Syariah', 'dispose' => true, 'done' => true],
            ['code' => '800', 'months_ago' => 2, 'day' => 19, 'number' => '018/LPPI-SDM/2026', 'sender' => 'Lembaga Pengembangan Perbankan Indonesia', 'subject' => 'Penawaran Sertifikasi Manajemen Risiko Jenjang 1-3', 'dispose' => false, 'done' => false],
            ['code' => '500', 'months_ago' => 1, 'day' => 5, 'number' => '312/PT-AMANAH/PKS/2026', 'sender' => 'PT Amanah Nusantara Abadi', 'subject' => 'Permohonan Perpanjangan Perjanjian Payroll Karyawan', 'dispose' => true, 'done' => false],
            ['code' => '700', 'months_ago' => 1, 'day' => 16, 'number' => 'S-204/OJK-SOLO/2026', 'sender' => 'OJK Kantor Solo', 'subject' => 'Evaluasi Penerapan Anti Pencucian Uang (APU-PPT)', 'dispose' => true, 'done' => false],
            ['code' => '900', 'months_ago' => 0, 'day' => 3, 'number' => '077/KAP-HENDRA/2026', 'sender' => 'KAP Hendra & Rekan', 'subject' => 'Jadwal Audit Laporan Keuangan Tahunan', 'dispose' => true, 'done' => false],
            ['code' => '100', 'months_ago' => 0, 'day' => 11, 'number' => '019/NOT-RINA/XI/2026', 'sender' => 'Notaris & PPAT Rina Wijaya, S.H.', 'subject' => 'Pengiriman Salinan Akta Pengikatan Jaminan Nasabah', 'dispose' => false, 'done' => false],
        ];

        $incomingSeq = 0;
        foreach ($incomingSamples as $sample) {
            $incomingSeq++;
            $letterDate = Carbon::now()->subMonths($sample['months_ago'])->setDay(min($sample['day'], 28))->startOfDay();
            $receivedAt = (clone $letterDate)->addDays(1);
            if ($receivedAt->isFuture()) {
                $receivedAt = Carbon::today();
                $letterDate = Carbon::today()->subDay();
            }

            $classification = $classifications->get($sample['code']) ?? $classifications->first();
            $agendaNumber = str_pad((string) $incomingSeq, 4, '0', STR_PAD_LEFT).'/'.$year;

            $letter = IncomingLetter::query()->create([
                'agenda_year' => $year,
                'agenda_seq' => $incomingSeq,
                'agenda_number' => $agendaNumber,
                'received_at' => $receivedAt,
                'letter_date' => $letterDate,
                'letter_number' => $sample['number'],
                'sender_name' => $sample['sender'],
                'subject' => $sample['subject'],
                'note' => 'Data contoh demo portofolio.',
                'classification_id' => $classification?->id,
                'status' => 'registered',
                'registered_by' => $admin->id,
            ]);

            if ($sample['dispose']) {
                $disposition = Disposition::query()->create([
                    'incoming_letter_id' => $letter->id,
                    'nature' => $sample['code'] === '700' ? DispositionNature::Segera : DispositionNature::Penting,
                    'forwarded_to' => [
                        $pegawai->name.' ('.$pegawai->position_title.')',
                        $pegawai2->name.' ('.$pegawai2->position_title.')',
                    ],
                    'instructions' => [
                        DispositionInstruction::SegeraTindakLanjuti->value,
                        DispositionInstruction::Koordinasikan->value,
                    ],
                    'note' => 'Mohon ditelaah dan disiapkan laporan tindak lanjutnya.',
                    'disposition_date' => $receivedAt,
                    'print_count' => $sample['done'] ? 1 : 0,
                    'printed_at' => $sample['done'] ? $receivedAt : null,
                    'created_by' => $superadmin->id,
                    'updated_by' => $superadmin->id,
                ]);

                $disposition->recipients()->create([
                    'user_id' => $pegawai->id,
                    'status' => $sample['done'] ? DispositionRecipientStatus::Done : DispositionRecipientStatus::New,
                    'read_at' => $sample['done'] ? $receivedAt->copy()->addHours(2) : null,
                    'done_at' => $sample['done'] ? $receivedAt->copy()->addDay() : null,
                    'done_note' => $sample['done'] ? 'Sudah ditindaklanjuti dan dilaporkan ke Direksi.' : null,
                    'notified_at' => $receivedAt,
                ]);

                $disposition->recipients()->create([
                    'user_id' => $pegawai2->id,
                    'status' => $sample['done'] ? DispositionRecipientStatus::Done : DispositionRecipientStatus::Read,
                    'read_at' => $receivedAt->copy()->addHours(3),
                    'done_at' => $sample['done'] ? $receivedAt->copy()->addDay() : null,
                    'done_note' => $sample['done'] ? 'Arsip kepatuhan telah diperbarui.' : null,
                    'notified_at' => $receivedAt,
                ]);
            }
        }

        LetterSequence::query()->updateOrCreate(
            ['category' => 'incoming_agenda', 'scope_key' => (string) $year],
            ['last_number' => $incomingSeq],
        );

        // 4. Surat Keluar Fiktif
        $outgoingSamples = [
            ['code' => '700', 'months_ago' => 5, 'day' => 15, 'recipient' => 'OJK Kantor Regional 3 Jateng & DIY', 'subject' => 'Tanggapan Laporan Pengawasan Triwulan I'],
            ['code' => '500', 'months_ago' => 4, 'day' => 18, 'recipient' => 'Koperasi Karyawan Sejahtera Sragen', 'subject' => 'Penawaran Skema Pembiayaan Murabahah Kolektif'],
            ['code' => '300', 'months_ago' => 3, 'day' => 24, 'recipient' => 'Bagian Perekonomian Setda Kab. Sragen', 'subject' => 'Konfirmasi Kehadiran Rapat Koordinasi BUMD'],
            ['code' => '100', 'months_ago' => 2, 'day' => 14, 'recipient' => 'ASBISINDO Jawa Tengah', 'subject' => 'Pendaftaran Peserta Pelatihan Tata Kelola Syariah'],
            ['code' => '500', 'months_ago' => 1, 'day' => 9, 'recipient' => 'PT Amanah Nusantara Abadi', 'subject' => 'Draft Addendum Perjanjian Kerjasama Payroll'],
            ['code' => '900', 'months_ago' => 1, 'day' => 22, 'recipient' => 'KPP Pratama Karanganyar', 'subject' => 'Penyampaian Laporan Pajak Masa Bulanan'],
            ['code' => '800', 'months_ago' => 0, 'day' => 6, 'recipient' => 'LPPI Jakarta', 'subject' => 'Surat Tugas Peserta Sertifikasi Manajemen Risiko'],
            ['code' => '100', 'months_ago' => 0, 'day' => 12, 'recipient' => 'Seluruh Kepala Bagian BPRS Sragen', 'subject' => 'Undangan Rapat Evaluasi Kinerja Bulanan'],
        ];

        $romans = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $outgoingSeq = 0;

        foreach ($outgoingSamples as $sample) {
            $outgoingSeq++;
            $letterDate = Carbon::now()->subMonths($sample['months_ago'])->setDay(min($sample['day'], 28))->startOfDay();
            if ($letterDate->isFuture()) {
                $letterDate = Carbon::today();
            }

            $classification = $classifications->get($sample['code']) ?? $classifications->first();
            $romanMonth = $romans[$letterDate->month] ?? 'I';
            $seqPadded3 = str_pad((string) $outgoingSeq, 3, '0', STR_PAD_LEFT);
            $seqPadded4 = str_pad((string) $outgoingSeq, 4, '0', STR_PAD_LEFT);

            OutgoingLetter::query()->create([
                'agenda_year' => $year,
                'agenda_seq' => $outgoingSeq,
                'agenda_number' => $seqPadded4.'/'.$year,
                'letter_number' => $seqPadded3.'/'.($classification?->code ?? '100').'/BPRS-SRG/'.$romanMonth.'/'.$year,
                'recipient' => $sample['recipient'],
                'subject' => $sample['subject'],
                'note' => 'Data contoh demo portofolio.',
                'classification_id' => $classification?->id,
                'letter_date' => $letterDate,
                'sent_date' => $letterDate,
                'created_by' => $admin->id,
            ]);
        }

        LetterSequence::query()->updateOrCreate(
            ['category' => 'outgoing_agenda', 'scope_key' => (string) $year],
            ['last_number' => $outgoingSeq],
        );

        LetterSequence::query()->updateOrCreate(
            ['category' => 'outgoing_number', 'scope_key' => (string) $year],
            ['last_number' => $outgoingSeq],
        );

        // 5. Perjanjian Kerjasama (PKS) Fiktif
        $pksSamples = [
            [
                'bss_pks_number' => '001/PKS/BPRS-SRG/II/'.$year,
                'partner_pks_number' => '014/ANA-LGL/II/'.$year,
                'partner_npwp' => '01.234.567.8-528.000',
                'months_ago' => 4,
                'partner_name' => 'PT Amanah Nusantara Abadi',
                'subject' => 'Kerjasama Layanan Payroll & Tabungan Karyawan',
                'pic_name' => 'Hendra Wijaya',
                'note' => 'Berlaku selama 2 tahun dengan evaluasi tahunan.',
            ],
            [
                'bss_pks_number' => '002/PKS/BPRS-SRG/V/'.$year,
                'partner_pks_number' => '088/KOP-SJ/V/'.$year,
                'partner_npwp' => '02.987.654.3-528.000',
                'months_ago' => 2,
                'partner_name' => 'Koperasi Karyawan Sejahtera Sragen',
                'subject' => 'Kerjasama Fasilitas Pembiayaan Mikro Syariah',
                'pic_name' => 'Sri Wahyuni',
                'note' => 'Skema murabahah kolektif untuk anggota koperasi.',
            ],
            [
                'bss_pks_number' => '003/PKS/BPRS-SRG/X/'.$year,
                'partner_pks_number' => '021/NOT-RW/X/'.$year,
                'partner_npwp' => '09.456.123.4-528.000',
                'months_ago' => 1,
                'partner_name' => 'Kantor Notaris & PPAT Rina Wijaya, S.H.',
                'subject' => 'Kerjasama Pembuatan Akta & Pengikatan Jaminan',
                'pic_name' => 'Rina Wijaya, S.H., M.Kn.',
                'note' => 'Rekanan resmi notaris wilayah Kabupaten Sragen.',
            ],
        ];

        foreach ($pksSamples as $pks) {
            $date = Carbon::now()->subMonths($pks['months_ago'])->setDay(12)->startOfDay();
            CooperationAgreement::query()->create([
                'bss_pks_number' => $pks['bss_pks_number'],
                'partner_pks_number' => $pks['partner_pks_number'],
                'partner_npwp' => $pks['partner_npwp'],
                'agreement_date' => $date,
                'partner_name' => $pks['partner_name'],
                'subject' => $pks['subject'],
                'pic_name' => $pks['pic_name'],
                'note' => $pks['note'],
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
        }
    }
}
