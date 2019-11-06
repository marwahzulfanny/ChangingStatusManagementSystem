-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS stu_status;
CREATE TABLE `stu_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `term` int(11) NOT NULL COMMENT 'timing.id',
  `status` enum('Aktif','Cuti','Overseas') NOT NULL COMMENT 'status yang diajukan',
  `action` enum('Diajukan','Disetujui','Ditolak') NOT NULL,
  `actions_status` enum('menanti pengecekan','Disetujui','Ditolak','menanti pengecekan pasca permintaan banding') NOT NULL COMMENT 'status akademik mahasiswa',
  `action_date` datetime NOT NULL COMMENT 'tanggal action dilakukan',
  `action_user` int(11) NOT NULL COMMENT 'user id yg melakukan action',
  `note` tinytext NOT NULL,
  `parent` int(11) NOT NULL COMMENT 'stu_status.id yang terkait',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `stu_status` (`id`, `user`, `term`, `status`, `action`, `action_date`, `action_user`, `note`, `parent`) VALUES
(1,	3,	6,	'Aktif',	'Disetujui',	'2019-08-18 23:32:32',	1,	'',	0),
(2,	4,	6,	'Aktif',	'Disetujui',	'2019-08-18 23:33:34',	1,	'',	0),
(3,	5,	6,	'Aktif',	'Disetujui',	'2019-08-18 23:33:34',	1,	'',	0),
(4,	6,	6,	'Aktif',	'Disetujui',	'2019-08-18 23:33:34',	1,	'',	0),
(5,	7,	6,	'Aktif',	'Disetujui',	'2019-08-18 23:33:34',	1,	'',	0);

DROP TABLE IF EXISTS `tagihan`;
CREATE TABLE `tagihan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `description` tinytext NOT NULL,
  `amount` int(11) NOT NULL,
  `date_bill` datetime NOT NULL COMMENT 'tgl tagihan dipost',
  `note` text NOT NULL,
  `payment_proof` tinytext NOT NULL,
  `payment_proof_date` datetime NOT NULL,
  `status` enum('Waiting payment','Waiting payment verification','Payment verification failed','Installment in progress','Paid') NOT NULL DEFAULT 'Waiting payment' COMMENT '1:memenuhi syarat (diisi oleh petugas, misal boleh dicicil, setelah ada cicilan pertama, maka status ok)',
  `last_status_change` datetime NOT NULL COMMENT 'tgl terakhir terjadi perubahan status',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='hanya utk siswa aktif (bukan calon siswa)';

INSERT INTO `tagihan` (`id`, `user`, `description`, `amount`, `date_bill`, `note`, `payment_proof`, `payment_proof_date`, `status`, `last_status_change`) VALUES
(1,	3,	'BOP Semester 1',	3000000,	'2019-08-21 05:07:34',	'Demo Admin (2019-08-17 10:43:58): ini bukti yg benar. thx.; Demo Admin (2019-08-21 05:10:24): ok sudah diterima.',	'892bc-capturetes.png',	'2019-08-17 10:43:58',	'Paid',	'2019-08-21 05:10:24'),
(2,	3,	'BOP 3',	5780000,	'2019-08-17 06:04:21',	'boleh dicicil; Mahasiswa (2019-09-02 05:20:19): ini bukti transfer cicilan 1',	'9c6b3-pengesahan-laporan.pdf',	'2019-09-02 05:20:19',	'Waiting payment verification',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `timing`;
CREATE TABLE `timing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_start` int(11) NOT NULL COMMENT '2017 --> 2017/2018',
  `semester` enum('Genap','Ganjil') NOT NULL,
  `start_date` date NOT NULL COMMENT 'max bayar = 1 bulan setelah ini.',
  `end_date` date NOT NULL,
  `UTS_start` date NOT NULL COMMENT 'uts_end = 2 pekan setelah ini',
  `UAS_start` date NOT NULL COMMENT 'uas_end = 2 pekan setelah ini. max input nilai = 2 pekan setelah ini',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='define start and end dates of a semester';

INSERT INTO `timing` (`id`, `year_start`, `semester`, `start_date`, `end_date`, `UTS_start`, `UAS_start`) VALUES
(1,	2016,	'Genap',	'2017-02-01',	'2017-06-30',	'0000-00-00',	'0000-00-00'),
(2,	2017,	'Ganjil',	'2017-09-01',	'2018-01-10',	'0000-00-00',	'0000-00-00'),
(3,	2017,	'Genap',	'2018-02-01',	'2018-06-30',	'0000-00-00',	'0000-00-00'),
(4,	2018,	'Ganjil',	'2018-09-01',	'2019-01-10',	'0000-00-00',	'0000-00-00'),
(5,	2018,	'Genap',	'2019-02-01',	'2019-06-30',	'0000-00-00',	'0000-00-00'),
(6,	2019,	'Ganjil',	'2019-09-01',	'2020-01-10',	'0000-00-00',	'0000-00-00'),
(7,	2019,	'Genap',	'2020-02-01',	'2020-06-30',	'0000-00-00',	'0000-00-00');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL COMMENT 'nama lengkap',
  `title_front` varchar(80) NOT NULL COMMENT 'gelar di depan nama',
  `title_back` varchar(80) NOT NULL COMMENT 'gelar di belakang nama',
  `username` varchar(50) NOT NULL COMMENT 'username untuk login, unique',
  `email` varchar(50) NOT NULL COMMENT 'unique',
  `tempat_lahir` enum('Aceh Barat','Aceh Barat Daya','Aceh Besar','Aceh Jaya','Aceh Selatan','Aceh Singkil','Aceh Tamiang','Aceh Tengah','Aceh Tenggara','Aceh Timur','Aceh Utara','Agam','Alor','Ambon','Asahan','Asmat','Badung','Balangan','Balikpapan','Banda Aceh','Bandar Lampung','Bandung','Bandung','Bandung Barat','Banggai','Banggai Kepulauan','Banggai Laut','Bangka','Bangka Barat','Bangka Selatan','Bangka Tengah','Bangkalan','Bangli','Banjar','Banjar','Banjarbaru','Banjarmasin','Banjarnegara','Bantaeng','Bantul','Banyuasin','Banyumas','Banyuwangi','Barito Kuala','Barito Selatan','Barito Timur','Barito Utara','Barru','baru','Batam','Batang','Batanghari','Batu','Batu Bara','Bau-Bau','Bekasi','Bekasi','Belitung','Belitung Timur','Belu','Bener Meriah','Bengkalis','Bengkayang','Bengkulu','Bengkulu Selatan','Bengkulu Tengah','Bengkulu Utara','Berau','Biak Numfor','Bima','Bima','Binjai','Bintan','Bireuen','Bitung','Blitar','Blitar','Blora','Boalemo','Bogor','Bogor','Bojonegoro','Bolaang Mongondow','Bolaang Mongondow Selatan','Bolaang Mongondow Timur','Bolaang Mongondow Utara','Bombana','Bondowoso','Bone','Bone Bolango','Bontang','Boven Digoel','Boyolali','Brebes','Bukittinggi','Buleleng','Bulukumba','Bulungan','Bungo','Buol','Buru','Buru Selatan','Buton','Buton Selatan','Buton Tengah','Buton Utara','Ciamis','Cianjur','Cilacap','Cilegon','Cimahi','Cirebon','Cirebon','Dairi','Deiyai','Deli Serdang','Demak','Denpasar','Depok','Dharmasraya','Dogiyai','Dompu','Donggala','Dumai','Empat Lawang','Ende','Enrekang','Fak-Fak','Flores Timur','Garut','Gayo Lues','Gianyar','Gorontalo','Gorontalo','Gorontalo Utara','Gowa','Gresik','Grobogan','Gunung Kidul','Gunung Mas','Gunungsitoli','Halmahera Barat','Halmahera Selatan','Halmahera Tengah','Halmahera Timur','Halmahera Utara','Hulu Sungai Selatan','Hulu Sungai Tengah','Hulu Sungai Utara','Humbang Hasundutan','Indragiri Hilir','Indragiri Hulu','Indramayu','Intan Jaya','Jakarta Barat','Jakarta Pusat','Jakarta Selatan','Jakarta Timur','Jakarta Utara','Jambi','Jayapura','Jayapura','Jayawijaya','Jember','Jembrana','Jeneponto','Jepara','Jombang','Kaimana','Kampar','Kapuas','Kapuas Hulu','Karanganyar','Karangasem','Karawang','Karimun','Karo','Katingan','Kaur','Kayong Utara','Kebumen','Kediri','Kediri','Keerom','Kendal','Kendari','Kepahiang','Kepulauan Anambas','Kepulauan Aru','Kepulauan Mentawai','Kepulauan Meranti','Kepulauan Sangihe','Kepulauan Selayar','Kepulauan Seribu','Kepulauan Siau Tagulandang Biaro','Kepulauan Sula','Kepulauan Talaud','Kepulauan Yapen','Kerinci','Ketapang','Klaten','Klungkung','Kolaka','Kolaka Timur','Kolaka Utara','Konawe','Konawe Kepulauan','Konawe Selatan','Konawe Utara','Kuantan Singingi','Kubu Raya','Kudus','Kulon Progo','Kuningan','Kupang','Kupang','Kutai Barat','Kutai Kartanegara','Kutai Timur','Labuhan Batu','Labuhan Batu Selatan','Labuhan Batu Utara','Lahat','Lamandau','Lamongan','Lampung Barat','Lampung Selatan','Lampung Tengah','Lampung Timur','Lampung Utara','Landak','Langkat','Langsa','Lanny Jaya','Lebak','Lebong','Lembata','Lhokseumawe','Lima Puluh','Lingga','Lombok Barat','Lombok Tengah','Lombok Timur','Lombok Utara','Lubuk Linggau','Lumajang','Luwu','Luwu Timur','Luwu Utara','Madiun','Madiun','Magelang','Magelang','Magetan','Mahakam Ulu','Majalengka','Majene','Makassar','Malaka','Malang','Malang','Malinau','Maluku Barat Daya','Maluku Tengah','Maluku Tenggara','Maluku Tenggara Barat','Mamasa','Mamberamo Raya','Mamberamo Tengah','Mamuju','Mamuju Tengah','Manado','Mandailing Natal','Manggarai','Manggarai Barat','Manggarai Timur','Manokwari','Manokwari Selatan','Mappi','Maros','Mataram','Maybrat','Medan','Melawi','Mempawah','Merangin','Merauke','Mesuji','Metro','Mimika','Minahasa','Minahasa Selatan','Minahasa Tenggara','Minahasa Utara','mobagu','Mojokerto','Mojokerto','Morowali','Morowali Utara','Muara Enim','Muaro Jambi','Muko-Muko','Muna','Muna Barat','Murung Raya','Musi Banyuasin','Musi Rawas','Musi Rawas Utara','Nabire','Nagan Raya','Nagekeo','Natuna','Nduga','Ngada','Nganjuk','Ngawi','Nias','Nias Barat','Nias Selatan','Nias Utara','Nunukan','Ogan Ilir','Ogan Komering Ilir','Ogan Komering Ulu','Ogan Komering Ulu Selatan','Ogan Komering Ulu Timur','Pacitan','Padang','Padang Lawas','Padang Lawas Utara','Padang Panjang','Padang Pariaman','Padangsidimpuan','Pagar Alam','Pakpak Bharat','Palangka Raya','Palembang','Palopo','Palu','Pamekasan','Pandeglang','Pangandaran','Pangkajene Dan Kepulauan','Pangkal Pinang','Paniai','Pare-Pare','Pariaman','Parigi Moutong','Pasaman','Pasaman Barat','Pasangkayu','Paser','Pasuruan','Pasuruan','Pati','Payakumbuh','Pegunungan Arfak','Pegunungan Bintang','Pekalongan','Pekalongan','Pekanbaru','Pelalawan','Pemalang','Pematang Siantar','Penajam Paser Utara','Penukal Abab Lematang Ilir','Pesawaran','Pesisir Barat','Pesisir Selatan','Pidie','Pidie Jaya','Pinrang','Pohuwato','Polewali Mandar','Ponorogo','Pontianak','Poso','Prabumulih','Pringsewu','Probolinggo','Probolinggo','Pulang Pisau','Pulau Morotai','Pulau Taliabu','Puncak','Puncak Jaya','Purbalingga','Purwakarta','Purworejo','Raja Ampat','Rejang Lebong','Rembang','Rokan Hilir','Rokan Hulu','Rote Ndao','Sabang','Sabu Raijua','Salatiga','Samarinda','Sambas','Samosir','Sampang','Sanggau','Sarmi','Sarolangun','Sawahlunto','Sekadau','Seluma','Semarang','Semarang','Seram Bagian Barat','Seram Bagian Timur','Serang','Serang','Serdang Bedagai','Seruyan','Siak','Sibolga','Sidenreng Rappang','Sidoarjo','Sigi','Sijunjung','Sikka','Simalungun','Simeulue','Singkawang','Sinjai','Sintang','Situbondo','Sleman','Solok','Solok','Solok Selatan','Soppeng','Sorong','Sorong','Sorong Selatan','Sragen','Subang','Subulussalam','Sukabumi','Sukabumi','Sukamara','Sukoharjo','Sumba Barat','Sumba Barat Daya','Sumba Tengah','Sumba Timur','Sumbawa','Sumbawa Barat','Sumedang','Sumenep','Sungai Penuh','Supiori','Surabaya','Surakarta','Tabalong','Tabanan','Takalar','Tambrauw','Tana Tidung','Tana Toraja','Tanah Bumbu','Tanah Datar','Tanah Laut','Tangerang','Tangerang','Tangerang Selatan','Tanggamus','Tanjung Balai','Tanjung Jabung Barat','Tanjung Jabung Timur','Tanjung Pinang','Tapanuli Selatan','Tapanuli Tengah','Tapanuli Utara','Tapin','Tarakan','Tasikmalaya','Tasikmalaya','Tebing Tinggi','Tebo','Tegal','Tegal','Teluk Bintuni','Teluk Wondama','Temanggung','Ternate','Tidore Kepulauan','Timor Tengah Selatan','Timor Tengah Utara','Toba Samosir','Tojo Una-Una','Tolikara','Toli-Toli','Tomohon','Toraja Utara','Trenggalek','Tual','Tuban','Tulang Bawang','Tulang Bawang Barat','Tulungagung','Wajo','Wakatobi','waringin Barat','waringin Timur','Waropen','Way Kanan','Wonogiri','Wonosobo','Yahukimo','Yalimo','Yogyakarta') NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `photo` varchar(50) NOT NULL COMMENT 'URL lokal utk foto (diisi saat user upload pasfoto)',
  `NIP_NPM` varchar(50) NOT NULL COMMENT 'nomor induk pegawai atau nomor pokok mahasiswa',
  `no_KTP` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL COMMENT 'no telp, diawali kode negara, tanpa tanda plus',
  `address` tinytext NOT NULL COMMENT 'alamat pos',
  `address_map_URL` tinytext NOT NULL COMMENT 'link ke alamat rumah di google map',
  `SMA` tinytext NOT NULL COMMENT 'asal SMA',
  `tahun_lulus_SMA` int(11) NOT NULL,
  `term_masuk` int(11) NOT NULL COMMENT 'timing',
  `batch` int(11) NOT NULL COMMENT 'tahun masuk (hanya untuk student dan alumni)',
  `major` int(11) DEFAULT NULL,
  `jalur` varchar(30) DEFAULT NULL COMMENT 'jalur masuk (regular, PNJ, etc.)',
  `password` varchar(80) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',
  `role` enum('Admin','Student Candidate','Student','Alumni','Lecturer','Finance','Manager','Marketing','SAA','School Representative') DEFAULT 'Student Candidate',
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Kong Hu Cu') DEFAULT NULL,
  `suku` varchar(30) DEFAULT NULL,
  `nama_ibu` varchar(30) DEFAULT NULL,
  `nama_ayah` varchar(30) DEFAULT NULL,
  `pekerjaan_ibu` enum('Tidak sekolah','SD','SMP','SMA','D1','D2','D3','D4/S1','S2','S3') DEFAULT NULL,
  `pendidikan_ayah` enum('Tidak sekolah','SD','SMP','SMA','D1','D2','D3','D4/S1','S2','S3') DEFAULT NULL,
  `pendidikan_ibu` enum('Tidak sekolah','SD','SMP','SMA','D1','D2','D3','D4/S1','S2','S3') DEFAULT NULL,
  `pekerjaan_ayah` tinytext,
  `penghasilan_orang_tua` int(11) DEFAULT NULL,
  `jumlah_kakak_kandung` int(11) DEFAULT NULL,
  `jumlah_adik_kandung` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `major` (`major`),CONSTRAINT `users_ibfk_1` FOREIGN KEY (`major`) REFERENCES `major` (`id`);
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='''Admin'',''Calon mahasiswa'',''Mahasiswa'',''Alumni'',''Dosen'',''Pensiunan'',''Pegawai'',''Manajer'',''Sekretariat''';

INSERT INTO `users` (`id`, `name`, `title_front`, `title_back`, `username`, `email`, `tempat_lahir`, `tanggal_lahir`, `gender`, `photo`, `NIP_NPM`, `no_KTP`, `phone`, `address`, `address_map_URL`, `SMA`, `tahun_lulus_SMA`, `term_masuk`, `batch`, `major`, `jalur`, `password`, `status`, `role`, `agama`, `suku`, `nama_ibu`, `nama_ayah`, `pekerjaan_ibu`, `pendidikan_ayah`, `pendidikan_ibu`, `pekerjaan_ayah`, `penghasilan_orang_tua`, `jumlah_kakak_kandung`, `jumlah_adik_kandung`, `created`, `last_login`) VALUES
(1,	'Demo Admin',	'',	'',	'demo',	'demo@admin.com',	'',	'0000-00-00',	'',	'11497-wmm.png',	'',	'',	'',	'',	'',	'',	0,	0,	0,	NULL,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Admin',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2017-06-26 14:37:16',	NULL),
(2,	'Sekretariat',	'',	'',	'sekret',	'demo@sekre.com',	'',	'0000-00-00',	'',	'98cfb-stillsnapshot000000.jpg',	'',	'',	'',	'',	'',	'',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Active',	'Finance',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-26 14:03:54',	NULL),
(3,	'Mahasiswa',	'',	'',	'mhs',	'demo@mhs.com',	'',	'0000-00-00',	'Female',	'07c08-win_20180926_17_52_11_pro.jpg',	'111',	'4567-qwerty',	'23456',	'fghjk',	'',	'',	0,	0,	2019,	2,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Active',	'Student',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-26 14:06:55',	NULL),
(4,	'Mahasiswa2',	'',	'',	'mhs2',	'dua@mhs.com',	'Jakarta Pusat',	'0000-00-00',	'',	'161c3-stillsnapshot000000.jpg',	'222',	'',	'',	'',	'',	'',	0,	0,	2019,	2,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Student',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:19:46',	NULL),
(5,	'Mahasiswa3',	'',	'',	'mhs3',	'mhs3@mhs.com',	'',	'0000-00-00',	'',	'',	'333',	'',	'',	'',	'',	'',	0,	0,	2018,	2,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Student',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:21:02',	NULL),
(6,	'Mahasiswa4',	'',	'',	'mhs4',	'mhs4@mhs.com',	'',	'0000-00-00',	'',	'',	'444',	'',	'',	'',	'',	'',	0,	0,	2019,	2,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Student',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:22:41',	NULL),
(7,	'Mahasiswa5',	'',	'',	'mhs5',	'mhs5@mhs.com',	'',	'0000-00-00',	'',	'',	'555',	'',	'',	'',	'',	'',	0,	0,	2019,	2,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Student',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:22:41',	NULL),
(8,	'Mahasiswa6',	'',	'',	'mhs6',	'mhs6@mhs.com',	'',	'0000-00-00',	'',	'',	'666',	'',	'',	'',	'',	'',	0,	0,	0,	3,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Student',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:22:41',	NULL),
(9,	'Mahasiswa7',	'',	'',	'mhs7',	'mhs7@mhs.com',	'',	'0000-00-00',	'',	'',	'777',	'',	'',	'',	'',	'',	0,	0,	0,	3,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Student',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:22:41',	NULL),
(10,	'Dosen2',	'Ir',	'SpD',	'dosen2',	'dosen2@mail.com',	'',	'0000-00-00',	'',	'',	'022',	'',	'',	'',	'',	'',	0,	0,	0,	NULL,	NULL,	'e10adc3949ba59abbe56e057f20f883e',	'Active',	'Lecturer',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:24:24',	NULL),
(11,	'Dosen1',	'Dr',	'SpD',	'dosen1',	'dosen1@mail.com',	'Mataram',	'1966-08-16',	'Female',	'',	'011',	'123456',	'1234567',	'qwertyui',	'',	'',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Active',	'Lecturer',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-05-27 22:25:00',	NULL),
(17,	'Muji Guru MAN1',	'',	'',	'muji@man1.sch.id',	'muji@man1.sch.id',	'Aceh Barat',	'0000-00-00',	'Male',	'',	'',	'',	'12345',	'Depok',	'',	'MAN 1',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Active',	'School Representative',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-08-06 03:50:43',	NULL),
(25,	'Ruki Harwahyu',	'',	'ST.',	'admin@ruki.web.id',	'admin@ruki.web.id',	'Aceh Barat',	'0000-00-00',	'Male',	'',	'',	'',	'89664301811',	'Margonda Raya',	'',	'SMA 1 BUMI',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Active',	'Alumni',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-08-06 04:09:52',	NULL),
(28,	'Resa si calon 1',	'',	'',	'admin@ruki.web.id',	'admin@ruki.web.id',	'Aceh Barat',	'1991-08-08',	'Male',	'',	'',	'',	'',	'',	'',	'SMA 1 BUMI',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Inactive',	'Student Candidate',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-08-06 04:20:16',	NULL),
(29,	'Riza Iqbal',	'',	'',	'rizaiqbal',	'riza.iqbal@gmail.com',	'',	'2019-08-28',	'Male',	'',	'',	'1235',	'1235',	'abcd',	'',	'',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Active',	'Manager',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(31,	'Rohmad Joni Pranoto',	'',	'',	'Joni',	'rohmat.joni@cs.ui.ac.id',	'',	'2019-08-08',	'Male',	'',	'',	'98734891274',	'2347124',	'asdijflaks',	'',	'',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Active',	'SAA',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(32,	'Alex Pramana',	'',	'',	'alexpram@yopmail.com',	'alexpram@yopmail.com',	'Aceh Barat',	'1997-09-09',	'Male',	'',	'',	'',	'',	'',	'',	'SMA 2 BUMI',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Inactive',	'Student Candidate',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-09-04 02:30:01',	NULL),
(33,	'Gustava',	'RM',	'',	'gustava@yopmail.com',	'gustava@yopmail.com',	'Aceh Barat',	'0000-00-00',	'Male',	'',	'',	'',	'38383838',	'BUMI',	'',	'SMA 1 BUMI',	0,	0,	0,	NULL,	NULL,	'e807f1fcf82d132f9bb018ca6738a19f',	'Inactive',	'School Representative',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2019-09-04 02:53:16',	NULL);

-- 2019-10-04 03:43:03
