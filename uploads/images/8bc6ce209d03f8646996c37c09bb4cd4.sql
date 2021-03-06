



USE [southbend_crm]
GO

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_dbo.DonorNavButtons_PopUp]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[DonorNavButtons] DROP CONSTRAINT [DF_dbo.DonorNavButtons_PopUp]
END

GO

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_dbo.DonorNavButtons_ShowOnLoggedOut]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[DonorNavButtons] DROP CONSTRAINT [DF_dbo.DonorNavButtons_ShowOnLoggedOut]
END

GO

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_dbo.DonorNavButtons_ShowOnLoggedIn]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[DonorNavButtons] DROP CONSTRAINT [DF_dbo.DonorNavButtons_ShowOnLoggedIn]
END

GO

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_dbo.DonorNavButtons_ShowOnLoggedInNoDEK]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[DonorNavButtons] DROP CONSTRAINT [DF_dbo.DonorNavButtons_ShowOnLoggedInNoDEK]
END

GO

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_DonorNavButtons_ShowOnHome]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[DonorNavButtons] DROP CONSTRAINT [DF_DonorNavButtons_ShowOnHome]
END

GO

IF  EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_DonorNavButtons_Active]') AND type = 'D')
BEGIN
ALTER TABLE [dbo].[DonorNavButtons] DROP CONSTRAINT [DF_DonorNavButtons_Active]
END

GO

USE [southbend_crm]
GO

/****** Object:  Table [dbo].[DonorNavButtons]    Script Date: 05/30/2012 14:05:46 ******/
IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[DonorNavButtons]') AND type in (N'U'))
DROP TABLE [dbo].[DonorNavButtons]
GO




USE [southbend_crm]
GO
/****** Object:  Table [dbo].[DonorNavButtons]    Script Date: 05/30/2012 14:04:23 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DonorNavButtons](
	[ButtonID] [int] IDENTITY(1,1) NOT NULL,
	[WebsiteID] [smallint] NOT NULL,
	[Title] [nvarchar](100) NOT NULL,
	[Icon] [nvarchar](50) NOT NULL,
	[IconLocation] [nvarchar](250) NULL,
	[IconTDWidth] [smallint] NOT NULL,
	[Href] [nvarchar](250) NOT NULL,
	[PopUp] [bit] NOT NULL,
	[TargetWindow] [nvarchar](50) NULL,
	[OnClick] [nvarchar](250) NULL,
	[SortOrder] [smallint] NULL,
	[ShowOnLoggedOut] [bit] NOT NULL,
	[ShowOnLoggedIn] [bit] NOT NULL,
	[ShowOnLoggedInNoDEK] [bit] NOT NULL,
	[ShowOnHome] [bit] NOT NULL,
	[Active] [bit] NOT NULL
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[DonorNavButtons] ON
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (1, 1, N'Home', N'blooddrop', N'/assets/images/icons', 0, N'index.cfm?group=home&function=', 0, NULL, NULL, 1, 0, 1, 1, 0, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (2, 1, N'Wellness Check', N'blooddrop', N'/assets/images/icons', 0, N'javascript:void(0);', 0, NULL, N'if(utiljs.confirmMsg(''To view your wellness check data you must first login. Click OK to be directed to the login page.'')) {window.location=''index.cfm?group=managedwellness''};', 4, 0, 0, 0, 1, 0)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (3, 1, N'Shop The Donor Store', N'present', N'/client_assets/images/layouts/donor/icons', 0, N'index.cfm?group=points&function=redeem', 0, NULL, NULL, 6, 0, 1, 0, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (4, 1, N'Donor Rewards', N'blooddrop', N'/assets/images/icons', 0, N'index.cfm?group=loyalty&function=faq', 0, NULL, NULL, 6, 0, 0, 0, 1, 0)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (5, 1, N'Donate Blood', N'blooddrop', N'/assets/images/icons', 0, N'index.cfm?group=op', 0, NULL, NULL, 2, 0, 0, 0, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (6, 1, N'Schedule A Donation', N'calendar', N'/client_assets/images/layouts/donor/icons', 0, N'javascript:void(0);', 0, NULL, N'if(utiljs.confirmMsg(''To view your donation history you must first login. Click OK to be directed to the login page.'')) {window.location=''index.cfm?group=history&function=donation''};', 1, 1, 1, 0, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (7, 1, N'My Donor Profile', N'silo', N'/client_assets/images/layouts/donor/icons', 0, N'javascript:void(0);', 0, NULL, N'if(utiljs.confirmMsg(''To view your profile you must first login. Click OK to be directed to the login page.'')) {window.location=''index.cfm?group=registration&Function=registration''};', 3, 0, 1, 0, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (8, 1, N'Order Donor ID Card', N'blooddrop', N'/assets/images/icons', 0, N'index.cfm?group=DIDCard', 0, NULL, NULL, 8, 0, 1, 0, 1, 0)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (9, 1, N'Contact Us', N'phone', N'/client_assets/images/layouts/donor/icons', 0, N'index.cfm?group=contactUs', 0, NULL, NULL, 9, 1, 1, 1, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (10, 1, N'Site Coordinator Login', N'blooddrop', N'/assets/images/icons', 0, N'/sitecoordinator', 0, NULL, NULL, 10, 1, 0, 0, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (11, 1, N'Logout', N'blood_drop', N'/client_assets/images/layouts/donor/icons', 0, N'index.cfm?group=logout&confirm=yes', 0, NULL, NULL, 11, 0, 1, 1, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (12, 1, N'Learn More', N'info', N'/assets/images/icons', 30, N'http://www.givebloodnow.com', 1, N'_blank', NULL, 3, 1, 0, 0, 1, 1)
INSERT [dbo].[DonorNavButtons] ([ButtonID], [WebsiteID], [Title], [Icon], [IconLocation], [IconTDWidth], [Href], [PopUp], [TargetWindow], [OnClick], [SortOrder], [ShowOnLoggedOut], [ShowOnLoggedIn], [ShowOnLoggedInNoDEK], [ShowOnHome], [Active]) VALUES (13, 1, N'Cholesterol Results', N'wellness', N'/assets/images/icons', 30, N'##', 0, NULL, NULL, 2, 0, 1, 1, 1, 1)

SET IDENTITY_INSERT [dbo].[DonorNavButtons] OFF
/****** Object:  Default [DF_dbo.DonorNavButtons_PopUp]    Script Date: 05/30/2012 14:04:23 ******/
ALTER TABLE [dbo].[DonorNavButtons] ADD  CONSTRAINT [DF_dbo.DonorNavButtons_PopUp]  DEFAULT ((0)) FOR [PopUp]
GO
/****** Object:  Default [DF_dbo.DonorNavButtons_ShowOnLoggedOut]    Script Date: 05/30/2012 14:04:23 ******/
ALTER TABLE [dbo].[DonorNavButtons] ADD  CONSTRAINT [DF_dbo.DonorNavButtons_ShowOnLoggedOut]  DEFAULT ((1)) FOR [ShowOnLoggedOut]
GO
/****** Object:  Default [DF_dbo.DonorNavButtons_ShowOnLoggedIn]    Script Date: 05/30/2012 14:04:23 ******/
ALTER TABLE [dbo].[DonorNavButtons] ADD  CONSTRAINT [DF_dbo.DonorNavButtons_ShowOnLoggedIn]  DEFAULT ((1)) FOR [ShowOnLoggedIn]
GO
/****** Object:  Default [DF_dbo.DonorNavButtons_ShowOnLoggedInNoDEK]    Script Date: 05/30/2012 14:04:23 ******/
ALTER TABLE [dbo].[DonorNavButtons] ADD  CONSTRAINT [DF_dbo.DonorNavButtons_ShowOnLoggedInNoDEK]  DEFAULT ((1)) FOR [ShowOnLoggedInNoDEK]
GO
/****** Object:  Default [DF_DonorNavButtons_ShowOnHome]    Script Date: 05/30/2012 14:04:23 ******/
ALTER TABLE [dbo].[DonorNavButtons] ADD  CONSTRAINT [DF_DonorNavButtons_ShowOnHome]  DEFAULT ((1)) FOR [ShowOnHome]
GO
/****** Object:  Default [DF_DonorNavButtons_Active]    Script Date: 05/30/2012 14:04:23 ******/
ALTER TABLE [dbo].[DonorNavButtons] ADD  CONSTRAINT [DF_DonorNavButtons_Active]  DEFAULT ((1)) FOR [Active]
GO
