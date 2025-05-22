/****** Object:  Table [dbo].[TSysDevRole]    Script Date: 8/5/2566 23:09:50 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[TSysDevRole]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[TSysDevRole](
	[FTRolCode] [varchar](5) NOT NULL,
	[FTRolName] [varchar](100) NOT NULL,
	[FDCreateOn] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[FTRolCode] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
INSERT [dbo].[TSysDevRole] ([FTRolCode], [FTRolName], [FDCreateOn]) VALUES (N'00001', N'Senior PGM', CAST(N'2023-05-08T15:27:28.827' AS DateTime))
GO
INSERT [dbo].[TSysDevRole] ([FTRolCode], [FTRolName], [FDCreateOn]) VALUES (N'00002', N'SA', CAST(N'2023-05-08T15:27:28.827' AS DateTime))
GO
INSERT [dbo].[TSysDevRole] ([FTRolCode], [FTRolName], [FDCreateOn]) VALUES (N'00003', N'Programmer', CAST(N'2023-05-08T15:27:28.827' AS DateTime))
GO
INSERT [dbo].[TSysDevRole] ([FTRolCode], [FTRolName], [FDCreateOn]) VALUES (N'00004', N'Report', CAST(N'2023-05-08T15:27:28.827' AS DateTime))
GO
INSERT [dbo].[TSysDevRole] ([FTRolCode], [FTRolName], [FDCreateOn]) VALUES (N'00005', N'Tester', CAST(N'2023-05-08T15:27:28.827' AS DateTime))
GO
INSERT [dbo].[TSysDevRole] ([FTRolCode], [FTRolName], [FDCreateOn]) VALUES (N'00006', N'Mgt', CAST(N'2023-05-08T15:27:28.827' AS DateTime))
GO

/****** Object:  Table [dbo].[TSysProvince_L]    Script Date: 8/5/2566 23:12:58 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[TSysProvince_L]') AND type in (N'U'))
BEGIN
CREATE TABLE [dbo].[TSysProvince_L](
	[FTPvnCode] [varchar](5) NOT NULL,
	[FTPvnName] [varchar](100) NOT NULL,
	[FNLngID] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[FTPvnCode] ASC,
	[FNLngID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
END
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'10', N'จ. กรุงเทพมหานคร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'10', N'Bangkok', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'11', N'จ. สมุทรปราการ', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'11', N'Samut Prakarn', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'12', N'จ. นนทบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'12', N'Nonthaburi', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'13', N'จ. ปทุมธานี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'13', N'Pathum Thani', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'14', N'จ. พระนครศรีอยุธยา', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'14', N'Phra Nakhon Si Ayutthaya', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'15', N'จ. อ่างทอง', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'15', N'Ang Thong', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'16', N'จ. ลพบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'16', N'Lop Buri', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'17', N'จ. สิงห์บุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'17', N'Sing Buri', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'18', N'จ. ชัยนาท', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'18', N'Chai Nat', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'19', N'จ. สระบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'19', N'Saraburi', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'20', N'จ. ชลบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'20', N'Chon Buri', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'21', N'จ. ระยอง', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'21', N'Rayong', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'22', N'จ. จันทบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'22', N'Chanthaburi', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'23', N'จ. ตราด', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'23', N'Trat', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'24', N'จ. ฉะเชิงเทรา', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'24', N'Chachoengsao', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'25', N'จ. ปราจีนบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'25', N'Prachin Buri', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'26', N'จ. นครนายก', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'26', N'Nakhon Nayok', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'27', N'จ. สระแก้ว', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'27', N'Sa kaeo', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'30', N'จ. นครราชสีมา', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'30', N'Nakhon Ratchasima', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'31', N'จ. บุรีรัมย์', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'31', N'Buri Ram', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'32', N'จ. สุรินทร์', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'32', N'Surin', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'33', N'จ. ศรีสะเกษ', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'33', N'Si Sa Ket', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'34', N'จ. อุบลราชธานี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'34', N'Ubon Ratchathani', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'35', N'จ. ยโสธร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'35', N'Yasothon', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'36', N'จ. ชัยภูมิ', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'36', N'Chaiyaphum', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'37', N'จ. อำนาจเจริญ', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'37', N'Amnat Charoen', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'38', N'จ. บึงกาฬ', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'38', N'Bueng Kan', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'39', N'จ. หนองบัวลำภู', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'39', N'Nong Bua Lam Phu', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'40', N'จ. ขอนแก่น', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'40', N'Khon Kaen', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'41', N'จ. อุดรธานี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'41', N'Udon Thani', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'42', N'จ. เลย', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'42', N'Loei', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'43', N'จ. หนองคาย', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'43', N'Nong Khai', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'44', N'จ. มหาสารคาม', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'44', N'Maha Sarakham', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'45', N'จ. ร้อยเอ็ด', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'45', N'Roi Et', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'46', N'จ. กาฬสินธุ์', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'46', N'Kalasin', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'47', N'จ. สกลนคร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'47', N'Sakon Nakhon', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'48', N'จ. นครพนม', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'48', N'Nakhon Phanom', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'49', N'จ. มุกดาหาร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'49', N'Mukdahan', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'50', N'จ. เชียงใหม่', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'50', N'Chiang Mai', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'51', N'จ. ลำพูน', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'51', N'Lamphun', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'52', N'จ. ลำปาง', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'52', N'Lampang', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'53', N'จ. อุตรดิตถ์', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'53', N'Uttaradit', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'54', N'จ. แพร่', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'54', N'Phrae', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'55', N'จ. น่าน', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'55', N'Nan', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'56', N'จ. พะเยา', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'56', N'Phayao', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'57', N'จ. เชียงราย', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'57', N'Chiang Rai', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'58', N'จ. แม่ฮ่องสอน', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'58', N'Mae Hong Son', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'60', N'จ. นครสวรรค์', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'60', N'Nakhon Sawan', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'61', N'จ. อุทัยธานี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'61', N'Uthai Thani', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'62', N'จ. กำแพงเพชร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'62', N'Kamphaeng Phet', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'63', N'จ. ตาก', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'63', N'Tak', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'64', N'จ. สุโขทัย', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'64', N'Sukhothai', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'65', N'จ. พิษณุโลก', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'65', N'Phitsanulok', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'66', N'จ. พิจิตร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'66', N'Phichit', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'67', N'จ. เพชรบูรณ์', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'67', N'Phetchabun', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'70', N'จ. ราชบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'70', N'Ratchaburi', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'71', N'จ. กาญจนบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'71', N'Kanchanaburi', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'72', N'จ. สุพรรณบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'72', N'Suphan Buri', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'73', N'จ. นครปฐม', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'73', N'Nakhon Pathom', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'74', N'จ. สมุทรสาคร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'74', N'Samut Sakhon', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'75', N'จ. สมุทรสงคราม', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'75', N'Samut Songkhram', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'76', N'จ. เพชรบุรี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'76', N'Phetchaburi', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'77', N'จ. ประจวบคีรีขันธ์', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'77', N'Prachuap Khiri Khan', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'80', N'จ. นครศรีธรรมราช', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'80', N'Nakhon Si Thammarat', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'81', N'จ. กระบี่', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'81', N'Krabi', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'82', N'จ. พังงา', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'82', N'Phang-nga', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'83', N'จ. ภูเก็ต', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'83', N'Phuket', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'84', N'จ. สุราษฎร์ธานี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'84', N'Surat Thani', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'85', N'จ. ระนอง', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'85', N'Ranong', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'86', N'จ. ชุมพร', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'86', N'Chumphon', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'90', N'จ. สงขลา', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'90', N'Songkhla', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'91', N'จ. สตูล', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'91', N'Satun', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'92', N'จ. ตรัง', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'92', N'Trang', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'93', N'จ. พัทลุง', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'93', N'Phatthalung', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'94', N'จ. ปัตตานี', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'94', N'Pattani', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'95', N'จ. ยะลา', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'95', N'Yala', 2)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'96', N'จ. นราธิวาส', 1)
GO
INSERT [dbo].[TSysProvince_L] ([FTPvnCode], [FTPvnName], [FNLngID]) VALUES (N'96', N'Narathiwat', 2)
GO
IF NOT EXISTS (SELECT * FROM sys.fn_listextendedproperty(N'MS_Description' , N'SCHEMA',N'dbo', N'TABLE',N'TSysProvince_L', N'COLUMN',N'FTPvnCode'))
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสจังหวัด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TSysProvince_L', @level2type=N'COLUMN',@level2name=N'FTPvnCode'
GO
IF NOT EXISTS (SELECT * FROM sys.fn_listextendedproperty(N'MS_Description' , N'SCHEMA',N'dbo', N'TABLE',N'TSysProvince_L', N'COLUMN',N'FTPvnName'))
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'ชื่อจังหวัด' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TSysProvince_L', @level2type=N'COLUMN',@level2name=N'FTPvnName'
GO
IF NOT EXISTS (SELECT * FROM sys.fn_listextendedproperty(N'MS_Description' , N'SCHEMA',N'dbo', N'TABLE',N'TSysProvince_L', N'COLUMN',N'FNLngID'))
	EXEC sys.sp_addextendedproperty @name=N'MS_Description', @value=N'รหัสภาษา' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'TSysProvince_L', @level2type=N'COLUMN',@level2name=N'FNLngID'
GO
