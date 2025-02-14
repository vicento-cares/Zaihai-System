USE [master]
GO

ALTER DATABASE [zaihai_db] SET COMPATIBILITY_LEVEL = 150
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [zaihai_db].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [zaihai_db] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [zaihai_db] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [zaihai_db] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [zaihai_db] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [zaihai_db] SET ARITHABORT OFF 
GO
ALTER DATABASE [zaihai_db] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [zaihai_db] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [zaihai_db] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [zaihai_db] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [zaihai_db] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [zaihai_db] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [zaihai_db] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [zaihai_db] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [zaihai_db] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [zaihai_db] SET  DISABLE_BROKER 
GO
ALTER DATABASE [zaihai_db] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [zaihai_db] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [zaihai_db] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [zaihai_db] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [zaihai_db] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [zaihai_db] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [zaihai_db] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [zaihai_db] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [zaihai_db] SET  MULTI_USER 
GO
ALTER DATABASE [zaihai_db] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [zaihai_db] SET DB_CHAINING OFF 
GO
ALTER DATABASE [zaihai_db] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [zaihai_db] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [zaihai_db] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [zaihai_db] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
ALTER DATABASE [zaihai_db] SET QUERY_STORE = OFF
GO
USE [zaihai_db]
GO
/****** Object:  Table [dbo].[m_accounts]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_accounts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[emp_no] [nvarchar](255) NOT NULL,
	[full_name] [nvarchar](255) NOT NULL,
	[role] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](2) NOT NULL,
 CONSTRAINT [PK_m_accounts] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_applicator]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_applicator](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[applicator_no] [nvarchar](100) NOT NULL,
	[zaihai_stock_address] [nvarchar](100) NOT NULL,
	[date_updated] [datetime2](2) NOT NULL,
 CONSTRAINT [PK_m_applicator_1] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_applicator_terminal]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_applicator_terminal](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[applicator_no] [nvarchar](100) NOT NULL,
	[terminal_name] [nvarchar](100) NOT NULL,
	[date_updated] [datetime2](2) NOT NULL,
 CONSTRAINT [PK_m_applicator] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_terminal]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_terminal](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[terminal_name] [nvarchar](100) NOT NULL,
	[line_address] [nvarchar](100) NOT NULL,
	[date_updated] [datetime2](2) NOT NULL,
 CONSTRAINT [PK_m_terminal] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_applicator_c]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_applicator_c](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[serial_no] [nvarchar](255) NOT NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](100) NOT NULL,
	[terminal_name] [nvarchar](100) NOT NULL,
	[zaihai_stock_address] [nvarchar](100) NOT NULL,
	[line_address] [nvarchar](100) NOT NULL,
	[inspection_date_time] [datetime2](2) NOT NULL,
	[inspection_shift] [nvarchar](5) NOT NULL,
	[adjustment_content] [nvarchar](255) NULL,
	[cross_section_result] [int] NULL,
	[inspected_by] [nvarchar](255) NOT NULL,
	[inspected_by_no] [nvarchar](255) NOT NULL,
	[checked_by] [nvarchar](255) NULL,
	[checked_by_no] [nvarchar](255) NULL,
	[confirmed_by] [nvarchar](255) NULL,
	[confirmed_by_no] [nvarchar](255) NULL,
	[judgement] [int] NULL,
	[ac1] [int] NOT NULL,
	[ac1_s] [nvarchar](255) NULL,
	[ac1_r] [nvarchar](255) NULL,
	[ac2] [int] NOT NULL,
	[ac2_s] [nvarchar](255) NULL,
	[ac2_r] [nvarchar](255) NULL,
	[ac3] [int] NOT NULL,
	[ac3_s] [nvarchar](255) NULL,
	[ac3_r] [nvarchar](255) NULL,
	[ac4] [int] NOT NULL,
	[ac4_s] [nvarchar](255) NULL,
	[ac4_r] [nvarchar](255) NULL,
	[ac5] [int] NOT NULL,
	[ac5_s] [nvarchar](255) NULL,
	[ac5_r] [nvarchar](255) NULL,
	[ac6] [int] NOT NULL,
	[ac6_s] [nvarchar](255) NULL,
	[ac6_r] [nvarchar](255) NULL,
	[ac7] [int] NOT NULL,
	[ac7_s] [nvarchar](255) NULL,
	[ac7_r] [nvarchar](255) NULL,
	[ac8] [int] NOT NULL,
	[ac8_s] [nvarchar](255) NULL,
	[ac8_r] [nvarchar](255) NULL,
	[ac9] [int] NOT NULL,
	[ac9_s] [nvarchar](255) NULL,
	[ac9_r] [nvarchar](255) NULL,
	[ac10] [int] NOT NULL,
	[ac10_s] [nvarchar](255) NULL,
	[ac10_r] [nvarchar](255) NULL,
 CONSTRAINT [PK_t_applicator_c] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_applicator_in_out]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_applicator_in_out](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[serial_no] [nvarchar](255) NOT NULL,
	[applicator_no] [nvarchar](100) NOT NULL,
	[terminal_name] [nvarchar](100) NOT NULL,
	[trd_no] [nvarchar](255) NOT NULL,
	[operator_out] [nvarchar](255) NOT NULL,
	[date_time_out] [datetime2](2) NOT NULL,
	[zaihai_stock_address] [nvarchar](255) NULL,
	[operator_in] [nvarchar](255) NULL,
	[date_time_in] [datetime2](2) NULL,
 CONSTRAINT [PK_t_applicator_in_out] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_applicator_in_out_history]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_applicator_in_out_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[serial_no] [nvarchar](255) NOT NULL,
	[applicator_no] [nvarchar](100) NOT NULL,
	[terminal_name] [nvarchar](100) NOT NULL,
	[trd_no] [nvarchar](255) NOT NULL,
	[operator_out] [nvarchar](255) NOT NULL,
	[date_time_out] [datetime2](2) NOT NULL,
	[zaihai_stock_address] [nvarchar](255) NOT NULL,
	[operator_in] [nvarchar](255) NOT NULL,
	[date_time_in] [datetime2](2) NOT NULL,
 CONSTRAINT [PK_t_applicator_in_out_history] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_applicator_list]    Script Date: 2024/07/24 8:59:51 am ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_applicator_list](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[car_maker] [nvarchar](255) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[applicator_no] [nvarchar](100) NOT NULL,
	[location] [nvarchar](255) NOT NULL,
	[status] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](2) NOT NULL,
 CONSTRAINT [PK_t_applicator_list] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[m_accounts] ON 

INSERT [dbo].[m_accounts] ([id], [emp_no], [full_name], [role], [date_updated]) VALUES (1, N'22-08675', N'Alcantara, Vince Dale D.', N'Shop', CAST(N'2024-07-06T13:24:41.0100000' AS DateTime2))
INSERT [dbo].[m_accounts] ([id], [emp_no], [full_name], [role], [date_updated]) VALUES (2, N'24-00000', N'Inpector1', N'Inspector', CAST(N'2024-07-10T09:33:42.9200000' AS DateTime2))
INSERT [dbo].[m_accounts] ([id], [emp_no], [full_name], [role], [date_updated]) VALUES (3, N'25-00000', N'ME1', N'ME', CAST(N'2024-08-22T11:32:42.9200000' AS DateTime2))
SET IDENTITY_INSERT [dbo].[m_accounts] OFF
GO
SET IDENTITY_INSERT [dbo].[m_applicator] ON 

INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (4, N'FS-11200/FS-100', N'R1-1', CAST(N'2024-07-19T15:55:36.6200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (5, N'FS-4400/FS-100', N'R1-2', CAST(N'2024-07-19T15:55:36.6500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (6, N'FS-11192/FS-100', N'R1-3', CAST(N'2024-07-19T15:55:36.6900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (7, N'FS-3451/FS-100', N'R1-4', CAST(N'2024-07-19T15:55:36.7300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (8, N'6W-12705/FS-100', N'R1-5', CAST(N'2024-07-19T15:55:36.7700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (9, N'FS-3689/FS-100', N'R1-6', CAST(N'2024-07-19T15:55:36.8100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (10, N'FS-3336/FS-100', N'R1-7', CAST(N'2024-07-19T15:55:36.8500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (11, N'FS-4686/FS-1000', N'R1-8', CAST(N'2024-07-19T15:55:36.8800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (12, N'FS-4910/FS-10000', N'R1-9', CAST(N'2024-07-19T15:55:36.9200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (13, N'FS-9572/FS-10300', N'R1-10', CAST(N'2024-07-19T15:55:36.9700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (14, N'FS-3319/FS-10300', N'R1-11', CAST(N'2024-07-19T15:55:37.0100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (15, N'FS-4864/FS-10300', N'R1-12', CAST(N'2024-07-19T15:55:37.0400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (16, N'FS-14425/FS-105100', N'R1-13', CAST(N'2024-07-19T15:55:37.1500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (17, N'6W-18739/FS-105600', N'R1-14', CAST(N'2024-07-19T15:55:37.1900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (18, N'FS-4021/FS-10600', N'R1-15', CAST(N'2024-07-19T15:55:37.2200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (19, N'FS-12997/FS-10600', N'R1-16', CAST(N'2024-07-19T15:55:37.2600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (20, N'FS-4886/FS-10600', N'R1-17', CAST(N'2024-07-19T15:55:37.3000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (21, N'FS-12995/FS-10600', N'R1-18', CAST(N'2024-07-19T15:55:37.3400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (22, N'FS-3468/FS-10600', N'R1-19', CAST(N'2024-07-19T15:55:37.3700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (23, N'FS-4303/FS-10600', N'R1-20', CAST(N'2024-07-19T15:55:37.4100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (24, N'FS-4176/FS-10600', N'R1-21', CAST(N'2024-07-19T15:55:37.4500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (25, N'FS-12996/FS-10600', N'R1-22', CAST(N'2024-07-19T15:55:37.4900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (26, N'FS-4917/FS-10600', N'R1-23', CAST(N'2024-07-19T15:55:37.5300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (27, N'FS-4335/FS-10600', N'R1-24', CAST(N'2024-07-19T15:55:37.5700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (28, N'FS-4741/FS-10600', N'R1-25', CAST(N'2024-07-19T15:55:37.6000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (29, N'FS-12999/FS-10700', N'R1-26', CAST(N'2024-07-19T15:55:37.6400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (30, N'FS-4177/FS-10700', N'R1-27', CAST(N'2024-07-19T15:55:37.6800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (31, N'FS-4766/FS-10700', N'R1-28', CAST(N'2024-07-19T15:55:37.7200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (32, N'FS-13000/FS-10700', N'R1-29', CAST(N'2024-07-19T15:55:37.7600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (33, N'FS-4338/FS-10700', N'R1-30', CAST(N'2024-07-19T15:55:37.7900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (34, N'FS-5932/FS-10700', N'R1-31', CAST(N'2024-07-19T15:55:37.8300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (35, N'FS-4887/FS-10700', N'R1-32', CAST(N'2024-07-19T15:55:37.8700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (36, N'FS-4403/FS-10700', N'R1-33', CAST(N'2024-07-19T15:55:37.9100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (37, N'FS-4790/FS-10700', N'R1-34', CAST(N'2024-07-19T15:55:37.9400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (38, N'FS-5934/FS-10700', N'R1-35', CAST(N'2024-07-19T15:55:37.9800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (39, N'FS-5703/FS-10700', N'R1-36', CAST(N'2024-07-19T15:55:38.0600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (40, N'FS-9927/FS-10700', N'R1-37', CAST(N'2024-07-19T15:55:38.1000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (41, N'FS-10556/FS-10700', N'R1-38', CAST(N'2024-07-19T15:55:38.1400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (42, N'FS-10279/FS-10700', N'R1-39', CAST(N'2024-07-19T15:55:38.1800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (43, N'FS-4163/FS-10700', N'R1-40', CAST(N'2024-07-19T15:55:38.2200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (44, N'FS-4343/FS-11000', N'R2-1', CAST(N'2024-07-19T15:55:38.2500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (45, N'FS-10192/FS-12700', N'R2-2', CAST(N'2024-07-19T15:55:38.2900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (46, N'FS-3091/FS-13700', N'R2-3', CAST(N'2024-07-19T15:55:38.3300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (47, N'FS-6755/FS-14400', N'R2-4', CAST(N'2024-07-19T15:55:38.3800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (48, N'FS-4746/FS-14400', N'R2-5', CAST(N'2024-07-19T15:55:38.4200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (49, N'FS-3696/FS-14600', N'R2-6', CAST(N'2024-07-19T15:55:38.4500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (50, N'FS-13027/FS-14600', N'R2-7', CAST(N'2024-07-19T15:55:38.5000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (51, N'FS-13948/FS-14600', N'R2-8', CAST(N'2024-07-19T15:55:38.5300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (52, N'FS-13945/FS-14600', N'R2-9', CAST(N'2024-07-19T15:55:38.5700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (53, N'FS-4282/FS-14700', N'R2-10', CAST(N'2024-07-19T15:55:38.6100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (54, N'FS-4787/FS-14700', N'R2-11', CAST(N'2024-07-19T15:55:38.6500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (55, N'FS-4674/FS-15100', N'R2-12', CAST(N'2024-07-19T15:55:38.6800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (56, N'FS-4675/FS-15200', N'R2-13', CAST(N'2024-07-19T15:55:38.7200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (57, N'FS-4434/FS-15300', N'R2-14', CAST(N'2024-07-19T15:55:38.7600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (58, N'FS-5915/FS-15300', N'R2-15', CAST(N'2024-07-19T15:55:38.7900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (59, N'FS-3729/FS-15300', N'R2-16', CAST(N'2024-07-19T15:55:38.8300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (60, N'FS-11161/FS-15300', N'R2-17', CAST(N'2024-07-19T15:55:38.8700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (61, N'6W-17851/FS-15300', N'R2-18', CAST(N'2024-07-19T15:55:38.9100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (62, N'FS-6614/FS-15300', N'R2-19', CAST(N'2024-07-19T15:55:38.9400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (63, N'FS-5489/FS-15400', N'R2-20', CAST(N'2024-07-19T15:55:38.9800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (64, N'FS-4851/FS-15400', N'R2-21', CAST(N'2024-07-19T15:55:39.0200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (65, N'FS-3287/FS-15400', N'R2-22', CAST(N'2024-07-19T15:55:39.0500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (66, N'FS-3339/FS-15400', N'R2-23', CAST(N'2024-07-19T15:55:39.0900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (67, N'FS-3323/FS-15400', N'R2-24', CAST(N'2024-07-19T15:55:39.1300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (68, N'FS-4632/FS-15400', N'R2-25', CAST(N'2024-07-19T15:55:39.1600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (69, N'FS-4192/FS-15400', N'R2-26', CAST(N'2024-07-19T15:55:39.2000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (70, N'FS-9775/FS-15400', N'R2-27', CAST(N'2024-07-19T15:55:39.2400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (71, N'FS-4852/FS-15400', N'R2-28', CAST(N'2024-07-19T15:55:39.2800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (72, N'FS-3547/FS-15400', N'R2-29', CAST(N'2024-07-19T15:55:39.3100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (73, N'FS-11361/FS-15400', N'R2-30', CAST(N'2024-07-19T15:55:39.3500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (74, N'FS-4039/FS-15400', N'R2-31', CAST(N'2024-07-19T15:55:39.3900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (75, N'FS-3111/FS-15400', N'R2-32', CAST(N'2024-07-19T15:55:39.4200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (76, N'FS-4440/FS-15400', N'R2-33', CAST(N'2024-07-19T15:55:39.4600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (77, N'FS-3258/FS-15400', N'R2-34', CAST(N'2024-07-19T15:55:39.5100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (78, N'FS-9552/FS-15400', N'R2-35', CAST(N'2024-07-19T15:55:39.5500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (79, N'FS-4445/FS-15500', N'R2-36', CAST(N'2024-07-19T15:55:39.5900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (80, N'FS-3700/FS-17100', N'R2-37', CAST(N'2024-07-19T15:55:39.6200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (81, N'6W-17349/FS-17100', N'R2-38', CAST(N'2024-07-19T15:55:39.6600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (82, N'FS-5535/FS-17200', N'R2-39', CAST(N'2024-07-19T15:55:39.7000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (83, N'FS-3701/FS-17200', N'R2-40', CAST(N'2024-07-19T15:55:39.7300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (84, N'FS-3376/FS-17200', N'R3-1', CAST(N'2024-07-19T15:55:39.7700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (85, N'FS-4443/FS-17200', N'R3-2', CAST(N'2024-07-19T15:55:39.8000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (86, N'FS-10270/FS-17300', N'R3-3', CAST(N'2024-07-19T15:55:39.8400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (87, N'FS-2901/FS-17300', N'R3-4', CAST(N'2024-07-19T15:55:39.8800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (88, N'FS-0385/FS-17300', N'R3-5', CAST(N'2024-07-19T15:55:39.9200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (89, N'FS-4854/FS-17300', N'R3-6', CAST(N'2024-07-19T15:55:39.9500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (90, N'FS-4446/FS-17300', N'R3-7', CAST(N'2024-07-19T15:55:39.9900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (91, N'FS-4895/FS-17300', N'R3-8', CAST(N'2024-07-19T15:55:40.0300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (92, N'FS-3311/FS-17300', N'R3-9', CAST(N'2024-07-19T15:55:40.0600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (93, N'FS-10785/FS-17300', N'R3-10', CAST(N'2024-07-19T15:55:40.1000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (94, N'FS-2898/FS-17300', N'R3-11', CAST(N'2024-07-19T15:55:40.1400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (95, N'FS-4612/FS-17300', N'R3-12', CAST(N'2024-07-19T15:55:40.1700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (96, N'FS-3262/FS-17300', N'R3-13', CAST(N'2024-07-19T15:55:40.2100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (97, N'FS-3550/FS-17300', N'R3-14', CAST(N'2024-07-19T15:55:40.2500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (98, N'FS-4894/FS-17300', N'R3-15', CAST(N'2024-07-19T15:55:40.2800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (99, N'FS-4855/FS-17300', N'R3-16', CAST(N'2024-07-19T15:55:40.3200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (100, N'FS-10272/FS-17400', N'R3-17', CAST(N'2024-07-19T15:55:40.3500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (101, N'6W-7775/FS-17400', N'R3-18', CAST(N'2024-07-19T15:55:40.3900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (102, N'FS-4057/FS-19400', N'R3-19', CAST(N'2024-07-19T15:55:40.4300000' AS DateTime2))
GO
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (103, N'6W-17549/FS-19500', N'R3-20', CAST(N'2024-07-19T15:55:40.4700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (104, N'FS-4863/FS-200', N'R3-21', CAST(N'2024-07-19T15:55:40.5000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (105, N'6W-8531-OM/FS-200', N'R3-22', CAST(N'2024-07-19T15:55:40.5400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (106, N'FS-10558/FS-200', N'R3-23', CAST(N'2024-07-19T15:55:40.5800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (107, N'FS-4670/FS-200', N'R3-24', CAST(N'2024-07-19T15:55:40.6100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (108, N'FS-3379/FS-200', N'R3-25', CAST(N'2024-07-19T15:55:40.6500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (109, N'FS-4393/FS-200', N'R3-26', CAST(N'2024-07-19T15:55:40.6900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (110, N'FS-5461/FS-200', N'R3-27', CAST(N'2024-07-19T15:55:40.7300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (111, N'6W-6776/FS-200', N'R3-28', CAST(N'2024-07-19T15:55:40.7600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (112, N'FS-10188/FS-200', N'R4-1', CAST(N'2024-07-19T15:55:40.9700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (113, N'FS-3453/FS-200', N'R4-2', CAST(N'2024-07-19T15:55:41.0500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (114, N'FS-9129/FS-200', N'R4-3', CAST(N'2024-07-19T15:55:41.0900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (115, N'6W-14229/FS-200', N'R4-4', CAST(N'2024-07-19T15:55:41.1300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (116, N'FS-10576/FS-200', N'R4-5', CAST(N'2024-07-19T15:55:41.1700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (117, N'FS-4455/FS-200', N'R4-6', CAST(N'2024-07-19T15:55:41.2000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (118, N'FS-4153/FS-200', N'R4-7', CAST(N'2024-07-19T15:55:41.2400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (119, N'FS-3690/FS-200', N'R4-8', CAST(N'2024-07-19T15:55:41.2800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (120, N'FS-4690/FS-2200', N'R4-9', CAST(N'2024-07-19T15:55:41.3100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (121, N'FS-5524/FS-2200', N'R4-10', CAST(N'2024-07-19T15:55:41.3500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (122, N'FS-4919/FS-2200', N'R4-11', CAST(N'2024-07-19T15:55:41.3900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (123, N'FS-3239/FS-2200', N'R4-12', CAST(N'2024-07-19T15:55:41.4300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (124, N'FS-17060/FS-2200', N'R4-13', CAST(N'2024-07-19T15:55:41.4600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (125, N'FS-4670/FS-2200', N'R4-14', CAST(N'2024-07-19T15:55:41.5000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (126, N'6W-10791/FS-2200', N'R4-15', CAST(N'2024-07-19T15:55:41.5400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (127, N'FS-4155/FS-2200', N'R4-16', CAST(N'2024-07-19T15:55:41.5700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (128, N'FS-12560/FS-23000', N'R4-17', CAST(N'2024-07-19T15:55:41.6100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (129, N'FS-4626/FS-23000', N'R4-18', CAST(N'2024-07-19T15:55:41.6500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (130, N'FS-13010/FS-23100', N'R4-19', CAST(N'2024-07-19T15:55:41.6900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (131, N'FS-4897/FS-23600', N'R4-20', CAST(N'2024-07-19T15:55:41.7300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (132, N'FS-13024/FS-23600', N'R4-21', CAST(N'2024-07-19T15:55:41.7700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (133, N'FS-17059/FS-23600', N'R4-22', CAST(N'2024-07-19T15:55:41.8200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (134, N'FS-4898/FS-23700', N'R4-23', CAST(N'2024-07-19T15:55:41.8600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (135, N'FS-4305/FS-2500', N'R4-24', CAST(N'2024-07-19T15:55:41.9000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (136, N'FS-13006/FS-2500', N'R4-25', CAST(N'2024-07-19T15:55:41.9400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (137, N'FS-4869/FS-2500', N'R4-26', CAST(N'2024-07-19T15:55:41.9800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (138, N'FS-4617/FS-2500', N'R4-27', CAST(N'2024-07-19T15:55:42.0200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (139, N'6W-16031/OS-20900', N'R4-28', CAST(N'2024-07-19T15:55:42.0500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (140, N'FS-10081/FS-26900', N'R5-1', CAST(N'2024-07-19T15:55:42.0900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (141, N'FS-10083/FS-2700', N'R5-2', CAST(N'2024-07-19T15:55:42.1300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (142, N'FS-0966/FS-2800', N'R5-3', CAST(N'2024-07-19T15:55:42.1600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (143, N'FS-5470/FS-2800', N'R5-4', CAST(N'2024-07-19T15:55:42.2000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (144, N'FS-13004/FS-2800', N'R5-5', CAST(N'2024-07-19T15:55:42.2300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (145, N'FS-5331/FS-2900', N'R5-6', CAST(N'2024-07-19T15:55:42.2700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (146, N'FS-10166/FS-2900', N'R5-7', CAST(N'2024-07-19T15:55:42.3100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (147, N'FS-5649/FS-2900', N'R5-8', CAST(N'2024-07-19T15:55:42.3400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (148, N'FS-5506/FS-300', N'R5-9', CAST(N'2024-07-19T15:55:42.3800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (149, N'FS-3851/FS-300', N'R5-10', CAST(N'2024-07-19T15:55:42.4200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (150, N'FS-4637/FS-300', N'R5-11', CAST(N'2024-07-19T15:55:42.4500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (151, N'6W-3327/FS-300', N'R5-12', CAST(N'2024-07-19T15:55:42.4900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (152, N'FS-5655/FS-300', N'R5-13', CAST(N'2024-07-19T15:55:42.5300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (153, N'FS-5652/FS-300', N'R5-14', CAST(N'2024-07-19T15:55:42.5600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (154, N'FS-4195/FS-300', N'R5-15', CAST(N'2024-07-19T15:55:42.6000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (155, N'FS-4416/FS-300', N'R5-16', CAST(N'2024-07-19T15:55:42.6400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (156, N'FS-10237/FS-300', N'R5-17', CAST(N'2024-07-19T15:55:42.6700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (157, N'FS-5654/FS-300', N'R5-18', CAST(N'2024-07-19T15:55:42.7100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (158, N'FS-3382/FS-300', N'R5-19', CAST(N'2024-07-19T15:55:42.7500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (159, N'6W-8543/FS-300', N'R5-20', CAST(N'2024-07-19T15:55:42.7800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (160, N'FS-10480/FS-300', N'R5-21', CAST(N'2024-07-19T15:55:42.8200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (161, N'FS-10233/FS-300', N'R5-22', CAST(N'2024-07-19T15:55:42.8500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (162, N'FS-0858/FS-300', N'R5-23', CAST(N'2024-07-19T15:55:42.8900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (163, N'FS-0860/FS-300', N'R5-24', CAST(N'2024-07-19T15:55:42.9300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (164, N'FS-11172/FS-300', N'R5-25', CAST(N'2024-07-19T15:55:42.9700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (165, N'6W-16202/FS-300', N'R5-26', CAST(N'2024-07-19T15:55:43.0000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (166, N'FS-4635/FS-300', N'R5-27', CAST(N'2024-07-19T15:55:43.0400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (167, N'FS-4639/FS-300', N'R5-28', CAST(N'2024-07-19T15:55:43.0800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (168, N'FS-5674/FS-300', N'R6-1', CAST(N'2024-07-19T15:55:43.1100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (169, N'FS-4191/FS-300', N'R6-2', CAST(N'2024-07-19T15:55:43.1500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (170, N'FS-11173/FS-300', N'R6-3', CAST(N'2024-07-19T15:55:43.1900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (171, N'FS-3454/FS-300', N'R6-4', CAST(N'2024-07-19T15:55:43.2200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (172, N'FS-10287/FS-300', N'R6-5', CAST(N'2024-07-19T15:55:43.2600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (173, N'FS-4661/FS-3100', N'R6-6', CAST(N'2024-07-19T15:55:43.2900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (174, N'FS-4173/FS-31200', N'R6-7', CAST(N'2024-07-19T15:55:43.3300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (175, N'FS-3498/FS-31200', N'R6-8', CAST(N'2024-07-19T15:55:43.3700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (176, N'FS-5941/FS-31300', N'R6-9', CAST(N'2024-07-19T15:55:43.4000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (177, N'FS-5572/FS-31400', N'R6-10', CAST(N'2024-07-19T15:55:43.4400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (178, N'FS-4755/FS-31400', N'R6-11', CAST(N'2024-07-19T15:55:43.4700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (179, N'FS-5859/FS-31500', N'R6-12', CAST(N'2024-07-19T15:55:43.5100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (180, N'FS-3361/FS-31500', N'R6-13', CAST(N'2024-07-19T15:55:43.5500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (181, N'FS-4252/FS-31500', N'R6-14', CAST(N'2024-07-19T15:55:43.5800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (182, N'6W-12729/FS-31500', N'R6-15', CAST(N'2024-07-19T15:55:43.6200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (183, N'FS-9146/FS-31500', N'R6-16', CAST(N'2024-07-19T15:55:43.7000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (184, N'6W-12953/FS-31500', N'R6-17', CAST(N'2024-07-19T15:55:43.7300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (185, N'FS-5355/FS-31500', N'R6-18', CAST(N'2024-07-19T15:55:43.7700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (186, N'6W-9409/FS-31600', N'R6-19', CAST(N'2024-07-19T15:55:43.8000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (187, N'FS-6169/FS-31900', N'R6-20', CAST(N'2024-07-19T15:55:43.8400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (188, N'FS-0082/FS-31900', N'R6-21', CAST(N'2024-07-19T15:55:43.8800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (189, N'FS-11362/FS-3200', N'R6-22', CAST(N'2024-07-19T15:55:43.9100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (190, N'FS-4059/FS-32200', N'R6-23', CAST(N'2024-07-19T15:55:43.9500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (191, N'FS-1008/FS-32200', N'R6-24', CAST(N'2024-07-19T15:55:43.9900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (192, N'FS-4679/FS-33900', N'R6-25', CAST(N'2024-07-19T15:55:44.0200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (193, N'FS-1005/FS-34100', N'R6-26', CAST(N'2024-07-19T15:55:44.0600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (194, N'FS-4681/FS-34800', N'R6-27', CAST(N'2024-07-19T15:55:44.1000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (195, N'FS-1104/FS-36300', N'R6-28', CAST(N'2024-07-19T15:55:44.1300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (196, N'FS-4665/FS-3700', N'R7-1', CAST(N'2024-07-19T15:55:44.1700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (197, N'6W-7998/FS-3700', N'R7-2', CAST(N'2024-07-19T15:55:44.2000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (198, N'FS-4871/FS-3700', N'R7-3', CAST(N'2024-07-19T15:55:44.2400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (199, N'6W-18431/FS-37400', N'R7-4', CAST(N'2024-07-19T15:55:44.2800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (200, N'FS-9892/FS-3800', N'R7-5', CAST(N'2024-07-19T15:55:44.3100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (201, N'FS-4065/FS-3800', N'R7-6', CAST(N'2024-07-19T15:55:44.3500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (202, N'FS-10208/FS-3800', N'R7-7', CAST(N'2024-07-19T15:55:44.3900000' AS DateTime2))
GO
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (203, N'FS-0826/FS-3800', N'R7-8', CAST(N'2024-07-19T15:55:44.4200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (204, N'FS-5464/FS-400', N'R7-9', CAST(N'2024-07-19T15:55:44.4600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (205, N'FS-2888/FS-400', N'R7-10', CAST(N'2024-07-19T15:55:44.4900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (206, N'FS-2887/FS-400', N'R7-11', CAST(N'2024-07-19T15:55:44.5300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (207, N'FS-10228/FS-400', N'R7-12', CAST(N'2024-07-19T15:55:44.5700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (208, N'FS-4656/FS-400', N'R7-13', CAST(N'2024-07-19T15:55:44.6100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (209, N'FS-9148/FS-400', N'R7-14', CAST(N'2024-07-19T15:55:44.6500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (210, N'FS-10245/FS-4100', N'R7-15', CAST(N'2024-07-19T15:55:44.6900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (211, N'FS-3958/FS-4100', N'R7-16', CAST(N'2024-07-19T15:55:44.7200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (212, N'FS-4876/FS-4100', N'R7-17', CAST(N'2024-07-19T15:55:44.7600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (213, N'FS-4875/FS-4100', N'R7-18', CAST(N'2024-07-19T15:55:44.7900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (214, N'FS-11821/FS-4100', N'R7-19', CAST(N'2024-07-19T15:55:44.8300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (215, N'FS-10249/FS-4100', N'R7-20', CAST(N'2024-07-19T15:55:44.8600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (216, N'FS-4874/FS-4100', N'R7-21', CAST(N'2024-07-19T15:55:44.9000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (217, N'FS-2884/FS-4100', N'R7-22', CAST(N'2024-07-19T15:55:44.9400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (218, N'FS-5663/FS-4100', N'R7-23', CAST(N'2024-07-19T15:55:44.9700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (219, N'FS-5517/FS-4100', N'R7-24', CAST(N'2024-07-19T15:55:45.0100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (220, N'FS-11820/FS-4100', N'R7-25', CAST(N'2024-07-19T15:55:45.0400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (221, N'6W-12217/FS-4100', N'R7-26', CAST(N'2024-07-19T15:55:45.0800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (222, N'FS-10247/FS-4100', N'R7-27', CAST(N'2024-07-19T15:55:45.1200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (223, N'FS-0959/FS-4100', N'R7-28', CAST(N'2024-07-19T15:55:45.1500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (224, N'FS-4151/FS-4100', N'R8-1', CAST(N'2024-07-19T15:55:45.1900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (225, N'FS-8967/FS-4100', N'R8-2', CAST(N'2024-07-19T15:55:45.2200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (226, N'FS-10172/FS-4200', N'R8-3', CAST(N'2024-07-19T15:55:45.2600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (227, N'FS-0800/FS-4200', N'R8-4', CAST(N'2024-07-19T15:55:45.2900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (228, N'FS-3460/FS-4200', N'R8-5', CAST(N'2024-07-19T15:55:45.3300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (229, N'FS-5665/FS-4200', N'R8-6', CAST(N'2024-07-19T15:55:45.3600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (230, N'FS-3352/FS-4200', N'R8-7', CAST(N'2024-07-19T15:55:45.4000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (231, N'FS-10171/FS-4200', N'R8-8', CAST(N'2024-07-19T15:55:45.4400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (232, N'6W-18742/FS-42400', N'R8-9', CAST(N'2024-07-19T15:55:45.4700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (233, N'6W-5024/FS-44000', N'R8-10', CAST(N'2024-07-19T15:55:45.5100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (234, N'6W-13880/FS-44000', N'R8-11', CAST(N'2024-07-19T15:55:45.5400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (235, N'FS-5581/FS-44400', N'R8-12', CAST(N'2024-07-19T15:55:45.5800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (236, N'FS-4973/FS-4600', N'R8-13', CAST(N'2024-07-19T15:55:45.6100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (237, N'FS-4777/FS-4600', N'R8-14', CAST(N'2024-07-19T15:55:45.6700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (238, N'FS-0965/FS-4700', N'R8-15', CAST(N'2024-07-19T15:55:45.7100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (239, N'FS-4625/FS-4700', N'R8-16', CAST(N'2024-07-19T15:55:45.7600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (240, N'FS-11368/FS-49100', N'R8-17', CAST(N'2024-07-19T15:55:45.8000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (241, N'FS-4892/FS-500', N'R8-18', CAST(N'2024-07-19T15:55:45.8300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (242, N'FS-10174/FS-5100', N'R8-19', CAST(N'2024-07-19T15:55:45.8700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (243, N'FS-4903/FS-5300', N'R8-20', CAST(N'2024-07-19T15:55:45.9100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (244, N'FS-3245/FS-5500', N'R8-21', CAST(N'2024-07-19T15:55:45.9500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (245, N'FS-3461/FS-5500', N'R8-22', CAST(N'2024-07-19T15:55:45.9800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (246, N'FS-3356/FS-5500', N'R8-23', CAST(N'2024-07-19T15:55:46.0200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (247, N'FS-10788/FS-5500', N'R8-24', CAST(N'2024-07-19T15:55:46.0600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (248, N'FS-3464/FS-5600', N'R8-25', CAST(N'2024-07-19T15:55:46.1000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (249, N'FS-5027/FS-5600', N'R8-26', CAST(N'2024-07-19T15:55:46.1300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (250, N'FS-0868/FS-5600', N'R8-27', CAST(N'2024-07-19T15:55:46.1700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (251, N'6W-10415-OM/FS-5600', N'R8-28', CAST(N'2024-07-19T15:55:46.2100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (252, N'FS-0131/FS-5600', N'R9-1', CAST(N'2024-07-19T15:55:46.2500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (253, N'FS-7706/FS-5600', N'R9-2', CAST(N'2024-07-19T15:55:46.2800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (254, N'FS-12985/FS-56400', N'R9-3', CAST(N'2024-07-19T15:55:46.3300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (255, N'FS-10207/FS-56400', N'R9-4', CAST(N'2024-07-19T15:55:46.3800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (256, N'FS-10582/FS-56900', N'R9-5', CAST(N'2024-07-19T15:55:46.4200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (257, N'FS-12991/FS-56900', N'R9-6', CAST(N'2024-07-19T15:55:46.4600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (258, N'FS-10241/FS-5800', N'R9-7', CAST(N'2024-07-19T15:55:46.5000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (259, N'FS-4348/FS-5800', N'R9-8', CAST(N'2024-07-19T15:55:46.5400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (260, N'FS-3249/FS-5800', N'R9-9', CAST(N'2024-07-19T15:55:46.5900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (261, N'FS-2813/FS-5800', N'R9-10', CAST(N'2024-07-19T15:55:46.6300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (262, N'FS-3335/FS-5900', N'R9-11', CAST(N'2024-07-19T15:55:46.6700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (263, N'FS-2896/FS-5900', N'R9-12', CAST(N'2024-07-19T15:55:46.7000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (264, N'FS-7653/FS-600', N'R9-13', CAST(N'2024-07-19T15:55:46.7400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (265, N'FS-5631/FS-6000', N'R9-14', CAST(N'2024-07-19T15:55:46.7700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (266, N'FS-4460/FS-6000', N'R9-15', CAST(N'2024-07-19T15:55:46.8800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (267, N'6W-17346/FS-6000', N'R9-16', CAST(N'2024-07-19T15:55:46.9200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (268, N'FS-17057/FS-6200', N'R9-17', CAST(N'2024-07-19T15:55:46.9600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (269, N'FS-3252/FS-6200', N'R9-18', CAST(N'2024-07-19T15:55:47.0000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (270, N'FS-5481/FS-6200', N'R9-19', CAST(N'2024-07-19T15:55:47.0300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (271, N'FS-3357/FS-6200', N'R9-20', CAST(N'2024-07-19T15:55:47.0700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (272, N'FS-3706/FS-6200', N'R9-21', CAST(N'2024-07-19T15:55:47.1100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (273, N'FS-3358/FS-6200', N'R9-22', CAST(N'2024-07-19T15:55:47.1500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (274, N'FS-2780/FS-6200', N'R9-23', CAST(N'2024-07-19T15:55:47.1900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (275, N'FS-5526/FS-6300', N'R9-24', CAST(N'2024-07-19T15:55:47.2200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (276, N'FS-5668/FS-6300', N'R9-25', CAST(N'2024-07-19T15:55:47.2600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (277, N'FS-3255/FS-6400', N'R9-26', CAST(N'2024-07-19T15:55:47.2900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (278, N'FS-9847/FS-6400', N'R9-27', CAST(N'2024-07-19T15:55:47.3300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (279, N'FS-3720/FS-6400', N'R9-28', CAST(N'2024-07-19T15:55:47.3600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (280, N'FS-12983/FS-6400', N'R10-1', CAST(N'2024-07-19T15:55:47.4000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (281, N'FS-3630/FS-6400', N'R10-2', CAST(N'2024-07-19T15:55:47.4400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (282, N'FS-12984/FS-6400', N'R10-3', CAST(N'2024-07-19T15:55:47.4700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (283, N'FS-9891/FS-6400', N'R10-4', CAST(N'2024-07-19T15:55:47.5100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (284, N'FS-3097/FS-6400', N'R10-5', CAST(N'2024-07-19T15:55:47.5500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (285, N'FS-10204/FS-6400', N'R10-6', CAST(N'2024-07-19T15:55:47.5800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (286, N'FS-10577/FS-6400', N'R10-7', CAST(N'2024-07-19T15:55:47.6200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (287, N'FS-11195/FS-6400', N'R10-8', CAST(N'2024-07-19T15:55:47.6500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (288, N'FS-10573/FS-6400', N'R10-9', CAST(N'2024-07-19T15:55:47.6900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (289, N'FS-4731/FS-6400', N'R10-10', CAST(N'2024-07-19T15:55:47.7300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (290, N'FS-3721/FS-6400', N'R10-11', CAST(N'2024-07-19T15:55:47.7600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (291, N'FS-3343/FS-6500', N'R10-12', CAST(N'2024-07-19T15:55:47.8000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (292, N'FS-4966/FS-6500', N'R10-13', CAST(N'2024-07-19T15:55:47.8400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (293, N'FS-3564/FS-6500', N'R10-14', CAST(N'2024-07-19T15:55:47.8700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (294, N'FS-10082/FS-65200', N'R10-15', CAST(N'2024-07-19T15:55:47.9200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (295, N'FS-10306/FS-65200', N'R10-16', CAST(N'2024-07-19T15:55:47.9600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (296, N'FS-1257/FS-6600', N'R10-17', CAST(N'2024-07-19T15:55:48.0000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (297, N'FS-4907/FS-6600', N'R10-18', CAST(N'2024-07-19T15:55:48.0400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (298, N'FS-4182/FS-6600', N'R10-19', CAST(N'2024-07-19T15:55:48.0900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (299, N'FS-14061/FS-66200', N'R10-20', CAST(N'2024-07-19T15:55:48.1200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (300, N'6W-17881/OS-41000', N'R10-21', CAST(N'2024-07-19T15:55:48.1600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (301, N'6W-17847/OS-41000', N'R10-22', CAST(N'2024-07-19T15:55:48.2000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (302, N'FS-4172/FS-6800', N'R10-23', CAST(N'2024-07-19T15:55:48.2400000' AS DateTime2))
GO
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (303, N'FS-13014/FS-6800', N'R10-24', CAST(N'2024-07-19T15:55:48.2800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (304, N'FS-13013/FS-6800', N'R10-25', CAST(N'2024-07-19T15:55:48.3200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (305, N'FS-4171/FS-6900', N'R10-26', CAST(N'2024-07-19T15:55:48.3500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (306, N'FS-4781/FS-6900', N'R10-27', CAST(N'2024-07-19T15:55:48.3900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (307, N'FS-5260/FS-7000', N'R10-28', CAST(N'2024-07-19T15:55:48.4300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (308, N'FS-4734/FS-7100', N'R11-1', CAST(N'2024-07-19T15:55:48.4700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (309, N'6W-17812/FS-7100', N'R11-2', CAST(N'2024-07-19T15:55:48.5100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (310, N'FS-11189/FS-72400', N'R11-3', CAST(N'2024-07-19T15:55:48.5500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (311, N'FS-12994/FS-72500', N'R11-4', CAST(N'2024-07-19T15:55:48.5900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (312, N'FS-13017/FS-74300', N'R11-5', CAST(N'2024-07-19T15:55:48.6200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (313, N'FS-13002/FS-74700', N'R11-6', CAST(N'2024-07-19T15:55:48.6600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (314, N'FS-13011/FS-74900', N'R11-7', CAST(N'2024-07-19T15:55:48.7000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (315, N'FS-13021/FS-76300', N'R11-8', CAST(N'2024-07-19T15:55:48.7400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (316, N'FS-13022/FS-76300', N'R11-9', CAST(N'2024-07-19T15:55:48.7800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (317, N'FS-13019/FS-76300', N'R11-10', CAST(N'2024-07-19T15:55:48.8200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (318, N'FS-10086/FS-76300', N'R11-11', CAST(N'2024-07-19T15:55:48.8500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (319, N'FS-3957/FS-77000', N'R11-12', CAST(N'2024-07-19T15:55:48.8900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (320, N'FS-10583/FS-77000', N'R11-13', CAST(N'2024-07-19T15:55:48.9300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (321, N'FS-10125/FS-77700', N'R11-14', CAST(N'2024-07-19T15:55:48.9600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (322, N'FS-12978/FS-77800', N'R11-15', CAST(N'2024-07-19T15:55:49.0000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (323, N'FS-10085/FS-79900', N'R11-16', CAST(N'2024-07-19T15:55:49.0800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (324, N'FS-4867/FS-800', N'R11-17', CAST(N'2024-07-19T15:55:49.1200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (325, N'FS-3704/FS-800', N'R11-18', CAST(N'2024-07-19T15:55:49.1600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (326, N'FS-5689/FS-800', N'R11-19', CAST(N'2024-07-19T15:55:49.1900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (327, N'FS-4839/FS-800', N'R11-20', CAST(N'2024-07-19T15:55:49.2300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (328, N'FS-4765/FS-8100', N'R11-21', CAST(N'2024-07-19T15:55:49.2700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (329, N'FS-3395/FS-8100', N'R11-22', CAST(N'2024-07-19T15:55:49.3000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (330, N'FS-10585/FS-81500', N'R11-23', CAST(N'2024-07-19T15:55:49.3400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (331, N'FS-4320/FS-900', N'R11-24', CAST(N'2024-07-19T15:55:49.3700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (332, N'6W-7733-0M/FS-92500', N'R11-25', CAST(N'2024-07-19T15:55:49.4100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (333, N'FS-3946/FS-9600', N'R11-26', CAST(N'2024-07-19T15:55:49.4500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (334, N'FS-10278/FS-9600', N'R11-27', CAST(N'2024-07-19T15:55:49.4900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (335, N'FS-12076/FS-9800', N'R11-28', CAST(N'2024-07-19T15:55:49.5200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (336, N'FS-13030/FS-9800', N'R12-1', CAST(N'2024-07-19T15:55:49.5600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (337, N'FS-13029/FS-9800', N'R12-2', CAST(N'2024-07-19T15:55:49.5900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (338, N'FS-13032/FS-9800', N'R12-3', CAST(N'2024-07-19T15:55:49.6300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (339, N'FS-4725/FS-9800', N'R12-4', CAST(N'2024-07-19T15:55:49.6600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (340, N'FS-5033/FS-9800', N'R12-5', CAST(N'2024-07-19T15:55:49.7000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (341, N'FS-12077/FS-9800', N'R12-6', CAST(N'2024-07-19T15:55:49.7400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (342, N'FS-5030/FS-9800', N'R12-7', CAST(N'2024-07-19T15:55:49.7700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (343, N'FS-13033/FS-9800', N'R12-8', CAST(N'2024-07-19T15:55:49.8100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (344, N'FS-13028/FS-9800', N'R12-9', CAST(N'2024-07-19T15:55:49.8500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (345, N'FS-5032/FS-9800', N'R12-10', CAST(N'2024-07-19T15:55:49.8800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (346, N'FS-3853/FS-9900', N'R12-11', CAST(N'2024-07-19T15:55:49.9200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (347, N'FS-3243/FS-9900', N'R12-12', CAST(N'2024-07-19T15:55:49.9500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (348, N'6W-16929/OE-10000', N'R12-13', CAST(N'2024-07-19T15:55:49.9900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (349, N'6W-17867/OE-1900', N'R12-14', CAST(N'2024-07-19T15:55:50.0300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (350, N'6W-7326/OE-20100', N'R12-15', CAST(N'2024-07-19T15:55:50.0600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (351, N'6W-17739/OE-20200', N'R12-16', CAST(N'2024-07-19T15:55:50.1000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (352, N'6W-17592/OE-2200', N'R12-17', CAST(N'2024-07-19T15:55:50.1300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (353, N'6W-17743/OE-23500', N'R12-18', CAST(N'2024-07-19T15:55:50.1700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (354, N'6W-18156/OE-25900', N'R12-19', CAST(N'2024-07-19T15:55:50.2000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (355, N'6W-19298/OE-25900', N'R12-20', CAST(N'2024-07-19T15:55:50.2500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (356, N'6W-19727/OE-25900', N'R12-21', CAST(N'2024-07-19T15:55:50.3200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (357, N'6W-19299/OE-25900', N'R12-22', CAST(N'2024-07-19T15:55:50.3500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (358, N'6W-17742/OE-26500', N'R12-23', CAST(N'2024-07-19T15:55:50.3900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (359, N'6W-19191/OE-27200', N'R12-24', CAST(N'2024-07-19T15:55:50.4300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (360, N'6W-19729/OE-30700', N'R12-25', CAST(N'2024-07-19T15:55:50.4600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (361, N'6W-17383/OE-30700', N'R12-26', CAST(N'2024-07-19T15:55:50.5000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (362, N'6W-17759/OE-30700', N'R12-27', CAST(N'2024-07-19T15:55:50.5300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (363, N'6W-19730/OE-30800', N'R12-28', CAST(N'2024-07-19T15:55:50.5700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (364, N'6W-17065/OE-30800', N'R13-1', CAST(N'2024-07-19T15:55:50.6000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (365, N'/OE-31400', N'R13-2', CAST(N'2024-07-19T15:55:50.6400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (366, N'6W-17788/OE-4900', N'R13-3', CAST(N'2024-07-19T15:55:50.6800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (367, N'/OE-4900', N'R13-4', CAST(N'2024-07-19T15:55:50.7100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (368, N'6W-17226/OE-7300', N'R13-5', CAST(N'2024-07-19T15:55:50.7500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (369, N'6W-19272/OE-7800', N'R13-6', CAST(N'2024-07-19T15:55:50.7900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (370, N'6W-17224/OE-8400', N'R13-7', CAST(N'2024-07-19T15:55:50.8200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (371, N'6W-17735/OS-15000', N'R13-8', CAST(N'2024-07-19T15:55:50.8600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (372, N'6W-17848/OS-19500', N'R13-9', CAST(N'2024-07-19T15:55:50.9000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (373, N'6W-10803-OM/OS-22000', N'R13-10', CAST(N'2024-07-19T15:55:50.9400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (374, N'6W-17841/OS-24800', N'R13-11', CAST(N'2024-07-19T15:55:50.9800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (375, N'6W-9396/OS-28600', N'R13-12', CAST(N'2024-07-19T15:55:51.0200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (376, N'FS-3725/OS-37700', N'R13-13', CAST(N'2024-07-19T15:55:51.0600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (377, N'6W-12264/OS-4200', N'R13-14', CAST(N'2024-07-19T15:55:51.0900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (378, N'6W-2434/OS-4300', N'R13-15', CAST(N'2024-07-19T15:55:51.1300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (379, N'6W-16989/OS-44700', N'R13-16', CAST(N'2024-07-19T15:55:51.1700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (380, N'6W-19279/OS-44700', N'R13-17', CAST(N'2024-07-19T15:55:51.2100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (381, N'6W-16989/OS-44700', N'R13-18', CAST(N'2024-07-19T15:55:51.2500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (382, N'6W-17751/OS-50200', N'R13-19', CAST(N'2024-07-19T15:55:51.2800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (383, N'6W-17750/OS-50300', N'R13-20', CAST(N'2024-07-19T15:55:51.3200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (384, N'6W-17807/OS-53400', N'R13-21', CAST(N'2024-07-19T15:55:51.3500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (385, N'6W-16986/OS-55700', N'R13-22', CAST(N'2024-07-19T15:55:51.4400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (386, N'6W-18392/OS-58700', N'R13-23', CAST(N'2024-07-19T15:55:51.4800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (387, N'6W-17298/OS-58700', N'R13-24', CAST(N'2024-07-19T15:55:51.5100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (388, N'6W-17745/OS-5900', N'R13-25', CAST(N'2024-07-19T15:55:51.5500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (389, N'6W-10040/OS-59500', N'R13-26', CAST(N'2024-07-19T15:55:51.5800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (390, N'6W-17873/OS-6000', N'R13-27', CAST(N'2024-07-19T15:55:51.6200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (391, N'6W-18197/OS-66300', N'R13-28', CAST(N'2024-07-19T15:55:51.6500000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (392, N'6W-18143/OS-71300', N'R14-1', CAST(N'2024-07-19T15:55:51.6900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (393, N'6W-17749/OS-74000', N'R14-2', CAST(N'2024-07-19T15:55:51.7300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (394, N'6W-17227/OS-76500', N'R14-3', CAST(N'2024-07-19T15:55:51.7600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (395, N'6W-18416/OS-78200', N'R14-4', CAST(N'2024-07-19T15:55:51.8000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (396, N'6W-19268/OS-79100', N'R14-5', CAST(N'2024-07-19T15:55:51.8300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (397, N'6W-17380/OS-8000', N'R14-6', CAST(N'2024-07-19T15:55:51.8700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (398, N'6W-19265/OS-82700', N'R14-7', CAST(N'2024-07-19T15:55:51.9100000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (399, N'6W-17748/OS-84800', N'R14-8', CAST(N'2024-07-19T15:55:51.9400000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (400, N'6W-19736/OS-87300', N'R14-9', CAST(N'2024-07-19T15:55:51.9800000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (401, N'FS-3702/OS-89700', N'R14-10', CAST(N'2024-07-19T15:55:52.0200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (402, N'FS-9826/FS-41200', N'R14-11', CAST(N'2024-07-19T15:55:52.0500000' AS DateTime2))
GO
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (403, N'6W-9729/FS-41200', N'R14-12', CAST(N'2024-07-19T15:55:52.0900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (404, N'6W-17572/FS-41200', N'R14-13', CAST(N'2024-07-19T15:55:52.1200000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (405, N'FS-13015/FS-75700', N'R14-14', CAST(N'2024-07-19T15:55:52.1600000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (406, N'FS-5685/FS-67300', N'R14-15', CAST(N'2024-07-19T15:55:52.1900000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (407, N'6W-17288/OE-28500', N'R14-16', CAST(N'2024-07-19T15:55:52.2300000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (408, N'6W-4457-OM/OE-28500', N'R14-17', CAST(N'2024-07-19T15:55:52.2700000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (409, N'FS-1263/OS-6100', N'R14-18', CAST(N'2024-07-19T15:55:52.3000000' AS DateTime2))
INSERT [dbo].[m_applicator] ([id], [applicator_no], [zaihai_stock_address], [date_updated]) VALUES (410, N'6W-17736/OS-6100', N'R14-19', CAST(N'2024-07-19T15:55:52.3400000' AS DateTime2))
SET IDENTITY_INSERT [dbo].[m_applicator] OFF
GO
SET IDENTITY_INSERT [dbo].[m_applicator_terminal] ON 

INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (4, N'FS-11200/FS-100', N'FDSF03', CAST(N'2024-07-19T15:53:41.2000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (5, N'FS-4400/FS-100', N'FDSF03', CAST(N'2024-07-19T15:53:41.2400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (6, N'FS-11192/FS-100', N'FDSF03', CAST(N'2024-07-19T15:53:41.2800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (7, N'FS-3451/FS-100', N'FDSF03', CAST(N'2024-07-19T15:53:41.3200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (8, N'6W-12705/FS-100', N'FDSF03', CAST(N'2024-07-19T15:53:41.3600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (9, N'FS-3689/FS-100', N'FDSF03', CAST(N'2024-07-19T15:53:41.3900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (10, N'FS-3336/FS-100', N'FDSF03', CAST(N'2024-07-19T15:53:41.4300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (11, N'FS-4686/FS-1000', N'FLEF01', CAST(N'2024-07-19T15:53:41.4700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (12, N'FS-4910/FS-10000', N'AG-50-8', CAST(N'2024-07-19T15:53:41.5000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (13, N'FS-9572/FS-10300', N'HSEF03', CAST(N'2024-07-19T15:53:41.5400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (14, N'FS-3319/FS-10300', N'HSEF03', CAST(N'2024-07-19T15:53:41.5800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (15, N'FS-4864/FS-10300', N'HSEF03', CAST(N'2024-07-19T15:53:41.6200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (16, N'FS-14425/FS-105100', N'NTYF', CAST(N'2024-07-19T15:53:41.6800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (17, N'6W-18739/FS-105600', N'HZE05-F', CAST(N'2024-07-19T15:53:41.7200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (18, N'FS-4021/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:41.7600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (19, N'FS-12997/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:41.7900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (20, N'FS-4886/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:41.8300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (21, N'FS-12995/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:41.8700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (22, N'FS-3468/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:41.9000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (23, N'FS-4303/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:41.9400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (24, N'FS-4176/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:41.9700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (25, N'FS-12996/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:42.0100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (26, N'FS-4917/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:42.0500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (27, N'FS-4335/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:42.0900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (28, N'FS-4741/FS-10600', N'JSNF', CAST(N'2024-07-19T15:53:42.1200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (29, N'FS-12999/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.1600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (30, N'FS-4177/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.2100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (31, N'FS-4766/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.2500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (32, N'FS-13000/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.2900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (33, N'FS-4338/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.3300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (34, N'FS-5932/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.3700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (35, N'FS-4887/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.4100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (36, N'FS-4403/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.4500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (37, N'FS-4790/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.4800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (38, N'FS-5934/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.5200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (39, N'FS-5703/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.5600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (40, N'FS-9927/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.6000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (41, N'FS-10556/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.6400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (42, N'FS-10279/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.6800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (43, N'FS-4163/FS-10700', N'JSNF03', CAST(N'2024-07-19T15:53:42.7100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (44, N'FS-4343/FS-11000', N'DHE-F', CAST(N'2024-07-19T15:53:42.7500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (45, N'FS-10192/FS-12700', N'ALCF', CAST(N'2024-07-19T15:53:42.7900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (46, N'FS-3091/FS-13700', N'JMX5AF-S', CAST(N'2024-07-19T15:53:42.8300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (47, N'FS-6755/FS-14400', N'STDCM-105', CAST(N'2024-07-19T15:53:42.8700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (48, N'FS-4746/FS-14400', N'STDCM-105', CAST(N'2024-07-19T15:53:42.9000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (49, N'FS-3696/FS-14600', N'WPCM03', CAST(N'2024-07-19T15:53:42.9400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (50, N'FS-13027/FS-14600', N'WPCM03', CAST(N'2024-07-19T15:53:42.9800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (51, N'FS-13948/FS-14600', N'WPCM03', CAST(N'2024-07-19T15:53:43.0100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (52, N'FS-13945/FS-14600', N'WPCM03', CAST(N'2024-07-19T15:53:43.0500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (53, N'FS-4282/FS-14700', N'YOS-F', CAST(N'2024-07-19T15:53:43.0900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (54, N'FS-4787/FS-14700', N'YOS-F', CAST(N'2024-07-19T15:53:43.1200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (55, N'FS-4674/FS-15100', N'DHE-F', CAST(N'2024-07-19T15:53:43.1600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (56, N'FS-4675/FS-15200', N'DHE-F03', CAST(N'2024-07-19T15:53:43.2000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (57, N'FS-4434/FS-15300', N'TSN-F', CAST(N'2024-07-19T15:53:43.2300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (58, N'FS-5915/FS-15300', N'TSN-F', CAST(N'2024-07-19T15:53:43.2700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (59, N'FS-3729/FS-15300', N'TSN-F', CAST(N'2024-07-19T15:53:43.3100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (60, N'FS-11161/FS-15300', N'TSN-F', CAST(N'2024-07-19T15:53:43.3400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (61, N'6W-17851/FS-15300', N'TSN-F', CAST(N'2024-07-19T15:53:43.3800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (62, N'FS-6614/FS-15300', N'TSN-F', CAST(N'2024-07-19T15:53:43.4200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (63, N'FS-5489/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.4500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (64, N'FS-4851/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.4900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (65, N'FS-3287/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.5300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (66, N'FS-3339/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.5600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (67, N'FS-3323/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.6000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (68, N'FS-4632/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.6300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (69, N'FS-4192/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.6700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (70, N'FS-9775/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.7100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (71, N'FS-4852/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.7500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (72, N'FS-3547/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.7800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (73, N'FS-11361/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.8200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (74, N'FS-4039/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.8600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (75, N'FS-3111/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.8900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (76, N'FS-4440/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.9300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (77, N'FS-3258/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:43.9700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (78, N'FS-9552/FS-15400', N'TSN-F03', CAST(N'2024-07-19T15:53:44.0100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (79, N'FS-4445/FS-15500', N'NRSSF', CAST(N'2024-07-19T15:53:44.0500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (80, N'FS-3700/FS-17100', N'TSN-F20', CAST(N'2024-07-19T15:53:44.0900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (81, N'6W-17349/FS-17100', N'TSN-F20', CAST(N'2024-07-19T15:53:44.1200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (82, N'FS-5535/FS-17200', N'TSN-M', CAST(N'2024-07-19T15:53:44.1600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (83, N'FS-3701/FS-17200', N'TSN-M', CAST(N'2024-07-19T15:53:44.2000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (84, N'FS-3376/FS-17200', N'TSN-M', CAST(N'2024-07-19T15:53:44.2300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (85, N'FS-4443/FS-17200', N'TSN-M', CAST(N'2024-07-19T15:53:44.2700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (86, N'FS-10270/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.3100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (87, N'FS-2901/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.3400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (88, N'FS-0385/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.3800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (89, N'FS-4854/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.4200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (90, N'FS-4446/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.4600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (91, N'FS-4895/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.4900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (92, N'FS-3311/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.5300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (93, N'FS-10785/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.5600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (94, N'FS-2898/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.6000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (95, N'FS-4612/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.6400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (96, N'FS-3262/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.6900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (97, N'FS-3550/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.7300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (98, N'FS-4894/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.7700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (99, N'FS-4855/FS-17300', N'TSN-M03', CAST(N'2024-07-19T15:53:44.8100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (100, N'FS-10272/FS-17400', N'TSN-M20', CAST(N'2024-07-19T15:53:44.8500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (101, N'6W-7775/FS-17400', N'TSN-M20', CAST(N'2024-07-19T15:53:44.8800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (102, N'FS-4057/FS-19400', N'TSNY-F03', CAST(N'2024-07-19T15:53:44.9200000' AS DateTime2))
GO
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (103, N'6W-17549/FS-19500', N'TSNY-F', CAST(N'2024-07-19T15:53:44.9600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (104, N'FS-4863/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.0000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (105, N'6W-8531-OM/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.0400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (106, N'FS-10558/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.0900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (107, N'FS-4670/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.1400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (108, N'FS-3379/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.1800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (109, N'FS-4393/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.2200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (110, N'FS-5461/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.2600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (111, N'6W-6776/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.3000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (112, N'FS-10188/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.3300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (113, N'FS-3453/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.3700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (114, N'FS-9129/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.4100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (115, N'6W-14229/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.4400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (116, N'FS-10576/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.4800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (117, N'FS-4455/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.5200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (118, N'FS-4153/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.5500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (119, N'FS-3690/FS-200', N'NASZF11-1', CAST(N'2024-07-19T15:53:45.5900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (120, N'FS-4690/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.6300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (121, N'FS-5524/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.6700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (122, N'FS-4919/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.7100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (123, N'FS-3239/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.7400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (124, N'FS-17060/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.7800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (125, N'FS-4670/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.8900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (126, N'6W-10791/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.9300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (127, N'FS-4155/FS-2200', N'YSKM', CAST(N'2024-07-19T15:53:45.9700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (128, N'FS-12560/FS-23000', N'MPQNWF75-2', CAST(N'2024-07-19T15:53:46.0000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (129, N'FS-4626/FS-23000', N'MPQNWF75-2', CAST(N'2024-07-19T15:53:46.0400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (130, N'FS-13010/FS-23100', N'SNH-F01LI', CAST(N'2024-07-19T15:53:46.0800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (131, N'FS-4897/FS-23600', N'TSNY-M03', CAST(N'2024-07-19T15:53:46.1200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (132, N'FS-13024/FS-23600', N'TSNY-M03', CAST(N'2024-07-19T15:53:46.1500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (133, N'FS-17059/FS-23600', N'TSNY-M03', CAST(N'2024-07-19T15:53:46.1900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (134, N'FS-4898/FS-23700', N'TSNY-M', CAST(N'2024-07-19T15:53:46.2400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (135, N'FS-4305/FS-2500', N'MKF20', CAST(N'2024-07-19T15:53:46.2700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (136, N'FS-13006/FS-2500', N'MKF20', CAST(N'2024-07-19T15:53:46.3100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (137, N'FS-4869/FS-2500', N'MKF20', CAST(N'2024-07-19T15:53:46.3500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (138, N'FS-4617/FS-2500', N'MKF20', CAST(N'2024-07-19T15:53:46.3800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (139, N'6W-16031/OS-20900', N'#N/A', CAST(N'2024-07-19T15:53:46.4300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (140, N'FS-10081/FS-26900', N'MATF144-1', CAST(N'2024-07-19T15:53:46.4900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (141, N'FS-10083/FS-2700', N'MAF-10E', CAST(N'2024-07-19T15:53:46.5300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (142, N'FS-0966/FS-2800', N'MAF-YTA11', CAST(N'2024-07-19T15:53:46.5700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (143, N'FS-5470/FS-2800', N'MAF-YTA11', CAST(N'2024-07-19T15:53:46.6100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (144, N'FS-13004/FS-2800', N'MAF-YTA11', CAST(N'2024-07-19T15:53:46.6400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (145, N'FS-5331/FS-2900', N'ABD-F', CAST(N'2024-07-19T15:53:46.6800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (146, N'FS-10166/FS-2900', N'ABD-F', CAST(N'2024-07-19T15:53:46.7200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (147, N'FS-5649/FS-2900', N'ABD-F', CAST(N'2024-07-19T15:53:46.7500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (148, N'FS-5506/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:46.7900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (149, N'FS-3851/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:46.8300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (150, N'FS-4637/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:46.8700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (151, N'6W-3327/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:46.9000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (152, N'FS-5655/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:46.9400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (153, N'FS-5652/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:46.9700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (154, N'FS-4195/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.0100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (155, N'FS-4416/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.0500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (156, N'FS-10237/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.0700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (157, N'FS-5654/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.1500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (158, N'FS-3382/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.1800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (159, N'6W-8543/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.2200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (160, N'FS-10480/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.2600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (161, N'FS-10233/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.2900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (162, N'FS-0858/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.3500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (163, N'FS-0860/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.3900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (164, N'FS-11172/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.4300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (165, N'6W-16202/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.4700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (166, N'FS-4635/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.5000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (167, N'FS-4639/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.5400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (168, N'FS-5674/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.5700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (169, N'FS-4191/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.6100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (170, N'FS-11173/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.6500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (171, N'FS-3454/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.6900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (172, N'FS-10287/FS-300', N'SSGF', CAST(N'2024-07-19T15:53:47.7200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (173, N'FS-4661/FS-3100', N'ALEF32-1', CAST(N'2024-07-19T15:53:47.7600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (174, N'FS-4173/FS-31200', N'YSN-M03', CAST(N'2024-07-19T15:53:47.8000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (175, N'FS-3498/FS-31200', N'YSN-M03', CAST(N'2024-07-19T15:53:47.8300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (176, N'FS-5941/FS-31300', N'YSN-M', CAST(N'2024-07-19T15:53:47.8700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (177, N'FS-5572/FS-31400', N'YSN-F20', CAST(N'2024-07-19T15:53:47.9000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (178, N'FS-4755/FS-31400', N'YSN-F20', CAST(N'2024-07-19T15:53:47.9400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (179, N'FS-5859/FS-31500', N'YSN-F03', CAST(N'2024-07-19T15:53:47.9700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (180, N'FS-3361/FS-31500', N'YSN-F03', CAST(N'2024-07-19T15:53:48.0100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (181, N'FS-4252/FS-31500', N'YSN-F03', CAST(N'2024-07-19T15:53:48.0500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (182, N'6W-12729/FS-31500', N'YSN-F03', CAST(N'2024-07-19T15:53:48.0900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (183, N'FS-9146/FS-31500', N'YSN-F03', CAST(N'2024-07-19T15:53:48.1200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (184, N'6W-12953/FS-31500', N'YSN-F03', CAST(N'2024-07-19T15:53:48.1600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (185, N'FS-5355/FS-31500', N'YSN-F03', CAST(N'2024-07-19T15:53:48.2000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (186, N'6W-9409/FS-31600', N'YSN-F', CAST(N'2024-07-19T15:53:48.2300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (187, N'FS-6169/FS-31900', N'TSN-F01', CAST(N'2024-07-19T15:53:48.2700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (188, N'FS-0082/FS-31900', N'TSN-F01', CAST(N'2024-07-19T15:53:48.3000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (189, N'FS-11362/FS-3200', N'NTF', CAST(N'2024-07-19T15:53:48.3400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (190, N'FS-4059/FS-32200', N'YSN-M20', CAST(N'2024-07-19T15:53:48.3800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (191, N'FS-1008/FS-32200', N'YSN-M20', CAST(N'2024-07-19T15:53:48.4100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (192, N'FS-4679/FS-33900', N'MX15-F10298', CAST(N'2024-07-19T15:53:48.4500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (193, N'FS-1005/FS-34100', N'MCCF', CAST(N'2024-07-19T15:53:48.4800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (194, N'FS-4681/FS-34800', N'MX06-F10398', CAST(N'2024-07-19T15:53:48.5200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (195, N'FS-1104/FS-36300', N'MAF-STA11', CAST(N'2024-07-19T15:53:48.5600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (196, N'FS-4665/FS-3700', N'FDSF', CAST(N'2024-07-19T15:53:48.5900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (197, N'6W-7998/FS-3700', N'FDSF', CAST(N'2024-07-19T15:53:48.6300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (198, N'FS-4871/FS-3700', N'FDSF', CAST(N'2024-07-19T15:53:48.6700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (199, N'6W-18431/FS-37400', N'YSN-F01', CAST(N'2024-07-19T15:53:48.7000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (200, N'FS-9892/FS-3800', N'FDSF20', CAST(N'2024-07-19T15:53:48.7400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (201, N'FS-4065/FS-3800', N'FDSF20', CAST(N'2024-07-19T15:53:48.7700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (202, N'FS-10208/FS-3800', N'FDSF20', CAST(N'2024-07-19T15:53:48.8100000' AS DateTime2))
GO
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (203, N'FS-0826/FS-3800', N'FDSF20', CAST(N'2024-07-19T15:53:48.8500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (204, N'FS-5464/FS-400', N'SSEWF', CAST(N'2024-07-19T15:53:48.8800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (205, N'FS-2888/FS-400', N'SSEWF', CAST(N'2024-07-19T15:53:48.9200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (206, N'FS-2887/FS-400', N'SSEWF', CAST(N'2024-07-19T15:53:48.9500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (207, N'FS-10228/FS-400', N'SSEWF', CAST(N'2024-07-19T15:53:48.9900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (208, N'FS-4656/FS-400', N'SSEWF', CAST(N'2024-07-19T15:53:49.0200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (209, N'FS-9148/FS-400', N'SSEWF', CAST(N'2024-07-19T15:53:49.0600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (210, N'FS-10245/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.1000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (211, N'FS-3958/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.1400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (212, N'FS-4876/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.1800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (213, N'FS-4875/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.2200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (214, N'FS-11821/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.2600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (215, N'FS-10249/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.3000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (216, N'FS-4874/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.3300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (217, N'FS-2884/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.3700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (218, N'FS-5663/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.4100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (219, N'FS-5517/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.4500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (220, N'FS-11820/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.4900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (221, N'6W-12217/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.5200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (222, N'FS-10247/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.5600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (223, N'FS-0959/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.5900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (224, N'FS-4151/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.6300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (225, N'FS-8967/FS-4100', N'SSGM', CAST(N'2024-07-19T15:53:49.6700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (226, N'FS-10172/FS-4200', N'FLEF36-1', CAST(N'2024-07-19T15:53:49.7000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (227, N'FS-0800/FS-4200', N'FLEF36-1', CAST(N'2024-07-19T15:53:49.7400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (228, N'FS-3460/FS-4200', N'FLEF36-1', CAST(N'2024-07-19T15:53:49.7700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (229, N'FS-5665/FS-4200', N'FLEF36-1', CAST(N'2024-07-19T15:53:49.8100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (230, N'FS-3352/FS-4200', N'FLEF36-1', CAST(N'2024-07-19T15:53:49.8500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (231, N'FS-10171/FS-4200', N'FLEF36-1', CAST(N'2024-07-19T15:53:49.8800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (232, N'6W-18742/FS-42400', N'MQSF969-18', CAST(N'2024-07-19T15:53:49.9200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (233, N'6W-5024/FS-44000', N'JMX37-F03', CAST(N'2024-07-19T15:53:49.9500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (234, N'6W-13880/FS-44000', N'JMX37-F03', CAST(N'2024-07-19T15:53:49.9900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (235, N'FS-5581/FS-44400', N'HGT25-F', CAST(N'2024-07-19T15:53:50.0200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (236, N'FS-4973/FS-4600', N'MAF-YTA12', CAST(N'2024-07-19T15:53:50.0700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (237, N'FS-4777/FS-4600', N'MAF-YTA12', CAST(N'2024-07-19T15:53:50.1200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (238, N'FS-0965/FS-4700', N'MAF-YTA10', CAST(N'2024-07-19T15:53:50.1600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (239, N'FS-4625/FS-4700', N'MAF-YTA10', CAST(N'2024-07-19T15:53:50.1900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (240, N'FS-11368/FS-49100', N'LIFM-F', CAST(N'2024-07-19T15:53:50.2300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (241, N'FS-4892/FS-500', N'ANSSF55-1', CAST(N'2024-07-19T15:53:50.2700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (242, N'FS-10174/FS-5100', N'ALEM37-2', CAST(N'2024-07-19T15:53:50.3000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (243, N'FS-4903/FS-5300', N'ASEF43-1', CAST(N'2024-07-19T15:53:50.3400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (244, N'FS-3245/FS-5500', N'FDSWF03', CAST(N'2024-07-19T15:53:50.3700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (245, N'FS-3461/FS-5500', N'FDSWF03', CAST(N'2024-07-19T15:53:50.4100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (246, N'FS-3356/FS-5500', N'FDSWF03', CAST(N'2024-07-19T15:53:50.4500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (247, N'FS-10788/FS-5500', N'FDSWF03', CAST(N'2024-07-19T15:53:50.4800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (248, N'FS-3464/FS-5600', N'FDSWF', CAST(N'2024-07-19T15:53:50.5200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (249, N'FS-5027/FS-5600', N'FDSWF', CAST(N'2024-07-19T15:53:50.5500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (250, N'FS-0868/FS-5600', N'FDSWF', CAST(N'2024-07-19T15:53:50.5900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (251, N'6W-10415-OM/FS-5600', N'FDSWF', CAST(N'2024-07-19T15:53:50.6300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (252, N'FS-0131/FS-5600', N'FDSWF', CAST(N'2024-07-19T15:53:50.6600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (253, N'FS-7706/FS-5600', N'FDSWF', CAST(N'2024-07-19T15:53:50.7000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (254, N'FS-12985/FS-56400', N'FDSF20', CAST(N'2024-07-19T15:53:50.7400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (255, N'FS-10207/FS-56400', N'FDSF20', CAST(N'2024-07-19T15:53:50.7700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (256, N'FS-10582/FS-56900', N'JMX37-F', CAST(N'2024-07-19T15:53:50.8100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (257, N'FS-12991/FS-56900', N'JMX37-F', CAST(N'2024-07-19T15:53:50.8400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (258, N'FS-10241/FS-5800', N'SSGF01', CAST(N'2024-07-19T15:53:50.8800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (259, N'FS-4348/FS-5800', N'SSGF01', CAST(N'2024-07-19T15:53:50.9200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (260, N'FS-3249/FS-5800', N'SSGF01', CAST(N'2024-07-19T15:53:50.9500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (261, N'FS-2813/FS-5800', N'SSGF01', CAST(N'2024-07-19T15:53:50.9900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (262, N'FS-3335/FS-5900', N'SSGM01', CAST(N'2024-07-19T15:53:51.0700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (263, N'FS-2896/FS-5900', N'SSGM01', CAST(N'2024-07-19T15:53:51.1100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (264, N'FS-7653/FS-600', N'ANSSF55-2', CAST(N'2024-07-19T15:53:51.1400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (265, N'FS-5631/FS-6000', N'ASZF83-1', CAST(N'2024-07-19T15:53:51.1800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (266, N'FS-4460/FS-6000', N'ASZF83-1', CAST(N'2024-07-19T15:53:51.2200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (267, N'6W-17346/FS-6000', N'ASZF83-1', CAST(N'2024-07-19T15:53:51.2800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (268, N'FS-17057/FS-6200', N'FDSF', CAST(N'2024-07-19T15:53:51.3200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (269, N'FS-3252/FS-6200', N'FDSF', CAST(N'2024-07-19T15:53:51.3500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (270, N'FS-5481/FS-6200', N'FDSF', CAST(N'2024-07-19T15:53:51.3900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (271, N'FS-3357/FS-6200', N'FDSF', CAST(N'2024-07-19T15:53:51.4300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (272, N'FS-3706/FS-6200', N'FDSF', CAST(N'2024-07-19T15:53:51.4600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (273, N'FS-3358/FS-6200', N'FDSF', CAST(N'2024-07-19T15:53:51.5000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (274, N'FS-2780/FS-6200', N'FDSF', CAST(N'2024-07-19T15:53:51.5400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (275, N'FS-5526/FS-6300', N'MKSF', CAST(N'2024-07-19T15:53:51.5800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (276, N'FS-5668/FS-6300', N'MKSF', CAST(N'2024-07-19T15:53:51.6200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (277, N'FS-3255/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.6600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (278, N'FS-9847/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.7000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (279, N'FS-3720/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.7300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (280, N'FS-12983/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.7700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (281, N'FS-3630/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.8100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (282, N'FS-12984/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.8400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (283, N'FS-9891/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.8800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (284, N'FS-3097/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.9100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (285, N'FS-10204/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.9500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (286, N'FS-10577/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:51.9900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (287, N'FS-11195/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:52.0200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (288, N'FS-10573/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:52.0600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (289, N'FS-4731/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:52.1000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (290, N'FS-3721/FS-6400', N'FDSF03', CAST(N'2024-07-19T15:53:52.1300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (291, N'FS-3343/FS-6500', N'MKF03', CAST(N'2024-07-19T15:53:52.1700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (292, N'FS-4966/FS-6500', N'MKF03', CAST(N'2024-07-19T15:53:52.2800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (293, N'FS-3564/FS-6500', N'MKF03', CAST(N'2024-07-19T15:53:52.3200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (294, N'FS-10082/FS-65200', N'YECPF075', CAST(N'2024-07-19T15:53:52.3600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (295, N'FS-10306/FS-65200', N'YECPF075', CAST(N'2024-07-19T15:53:52.4000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (296, N'FS-1257/FS-6600', N'MKYF20', CAST(N'2024-07-19T15:53:52.4900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (297, N'FS-4907/FS-6600', N'MKYF20', CAST(N'2024-07-19T15:53:52.5300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (298, N'FS-4182/FS-6600', N'MKYF20', CAST(N'2024-07-19T15:53:52.5800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (299, N'FS-14061/FS-66200', N'AG-50', CAST(N'2024-07-19T15:53:52.6100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (300, N'6W-17881/OS-41000', N'STWAF075', CAST(N'2024-07-19T15:53:52.6600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (301, N'6W-17847/OS-41000', N'STWAF075', CAST(N'2024-07-19T15:53:52.7200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (302, N'FS-4172/FS-6800', N'STDCF-03', CAST(N'2024-07-19T15:53:52.7700000' AS DateTime2))
GO
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (303, N'FS-13014/FS-6800', N'STDCF-03', CAST(N'2024-07-19T15:53:52.8300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (304, N'FS-13013/FS-6800', N'STDCF-03', CAST(N'2024-07-19T15:53:52.8900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (305, N'FS-4171/FS-6900', N'STDCF-03', CAST(N'2024-07-19T15:53:52.9300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (306, N'FS-4781/FS-6900', N'STDCF-03', CAST(N'2024-07-19T15:53:52.9600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (307, N'FS-5260/FS-7000', N'STDCM', CAST(N'2024-07-19T15:53:53.0600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (308, N'FS-4734/FS-7100', N'STDCM', CAST(N'2024-07-19T15:53:53.1000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (309, N'6W-17812/FS-7100', N'STDCM', CAST(N'2024-07-19T15:53:53.1500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (310, N'FS-11189/FS-72400', N'ALCF094-US', CAST(N'2024-07-19T15:53:53.1900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (311, N'FS-12994/FS-72500', N'JMX5AF-P', CAST(N'2024-07-19T15:53:53.2300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (312, N'FS-13017/FS-74300', N'STDCF-189', CAST(N'2024-07-19T15:53:53.2700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (313, N'FS-13002/FS-74700', N'MAF-11E', CAST(N'2024-07-19T15:53:53.3000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (314, N'FS-13011/FS-74900', N'SNS-F03', CAST(N'2024-07-19T15:53:53.3400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (315, N'FS-13021/FS-76300', N'SWJCF', CAST(N'2024-07-19T15:53:53.3800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (316, N'FS-13022/FS-76300', N'SWJCF', CAST(N'2024-07-19T15:53:53.4100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (317, N'FS-13019/FS-76300', N'SWJCF', CAST(N'2024-07-19T15:53:53.4500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (318, N'FS-10086/FS-76300', N'SWJCF', CAST(N'2024-07-19T15:53:53.4900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (319, N'FS-3957/FS-77000', N'YPSF-1', CAST(N'2024-07-19T15:53:53.5200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (320, N'FS-10583/FS-77000', N'YPSF-1', CAST(N'2024-07-19T15:53:53.5600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (321, N'FS-10125/FS-77700', N'SWJCF085', CAST(N'2024-07-19T15:53:53.5900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (322, N'FS-12978/FS-77800', N'AMCF', CAST(N'2024-07-19T15:53:53.6300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (323, N'FS-10085/FS-79900', N'MAF-12E', CAST(N'2024-07-19T15:53:53.6600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (324, N'FS-4867/FS-800', N'APACF41-2', CAST(N'2024-07-19T15:53:53.7000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (325, N'FS-3704/FS-800', N'APACF41-2', CAST(N'2024-07-19T15:53:53.7400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (326, N'FS-5689/FS-800', N'APACF41-2', CAST(N'2024-07-19T15:53:53.7700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (327, N'FS-4839/FS-800', N'APACF41-2', CAST(N'2024-07-19T15:53:53.8100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (328, N'FS-4765/FS-8100', N'SNH-FLI', CAST(N'2024-07-19T15:53:53.8500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (329, N'FS-3395/FS-8100', N'SNH-FLI', CAST(N'2024-07-19T15:53:53.9100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (330, N'FS-10585/FS-81500', N'PCF20', CAST(N'2024-07-19T15:53:53.9500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (331, N'FS-4320/FS-900', N'FDSAF01', CAST(N'2024-07-19T15:53:54.0100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (332, N'6W-7733-0M/FS-92500', N'JWPFM', CAST(N'2024-07-19T15:53:54.0600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (333, N'FS-3946/FS-9600', N'JSNF01', CAST(N'2024-07-19T15:53:54.1000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (334, N'FS-10278/FS-9600', N'JSNF01', CAST(N'2024-07-19T15:53:54.1300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (335, N'FS-12076/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.1800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (336, N'FS-13030/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.2400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (337, N'FS-13029/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.2800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (338, N'FS-13032/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.3100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (339, N'FS-4725/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.3500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (340, N'FS-5033/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.3800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (341, N'FS-12077/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.4200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (342, N'FS-5030/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.4600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (343, N'FS-13033/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.4900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (344, N'FS-13028/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.5300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (345, N'FS-5032/FS-9800', N'YRHF', CAST(N'2024-07-19T15:53:54.5600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (346, N'FS-3853/FS-9900', N'YRHF', CAST(N'2024-07-19T15:53:54.6000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (347, N'FS-3243/FS-9900', N'YRHF', CAST(N'2024-07-19T15:53:54.6400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (348, N'6W-16929/OE-10000', N'PB52-2', CAST(N'2024-07-19T15:53:54.6700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (349, N'6W-17867/OE-1900', N'F84-2', CAST(N'2024-07-19T15:53:54.7100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (350, N'6W-7326/OE-20100', N'F08-3E', CAST(N'2024-07-19T15:53:54.7400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (351, N'6W-17739/OE-20200', N'F18-3E', CAST(N'2024-07-19T15:53:54.7800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (352, N'6W-17592/OE-2200', N'F32-5', CAST(N'2024-07-19T15:53:54.8200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (353, N'6W-17743/OE-23500', N'FKI-F03', CAST(N'2024-07-19T15:53:54.8500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (354, N'6W-18156/OE-25900', N'F84-2', CAST(N'2024-07-19T15:53:54.8900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (355, N'6W-19298/OE-25900', N'F84-2', CAST(N'2024-07-19T15:53:54.9200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (356, N'6W-19727/OE-25900', N'F84-2', CAST(N'2024-07-19T15:53:54.9600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (357, N'6W-19299/OE-25900', N'F84-2', CAST(N'2024-07-19T15:53:55.0000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (358, N'6W-17742/OE-26500', N'FKI-F', CAST(N'2024-07-19T15:53:55.0300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (359, N'6W-19191/OE-27200', N'FKI-F20', CAST(N'2024-07-19T15:53:55.0800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (360, N'6W-19729/OE-30700', N'F08-3E', CAST(N'2024-07-19T15:53:55.1200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (361, N'6W-17383/OE-30700', N'F08-3E', CAST(N'2024-07-19T15:53:55.1800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (362, N'6W-17759/OE-30700', N'F08-3E', CAST(N'2024-07-19T15:53:55.2900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (363, N'6W-19730/OE-30800', N'FKI-F03', CAST(N'2024-07-19T15:53:55.3200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (364, N'6W-17065/OE-30800', N'FKI-F03', CAST(N'2024-07-19T15:53:55.3600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (365, N'/OE-31400', N'F18-3E', CAST(N'2024-07-19T15:53:55.4200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (366, N'6W-17788/OE-4900', N'PB54-2', CAST(N'2024-07-19T15:53:55.4700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (367, N'/OE-4900', N'PB54-2', CAST(N'2024-07-19T15:53:55.5400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (368, N'6W-17226/OE-7300', N'PB213-2', CAST(N'2024-07-19T15:53:55.5700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (369, N'6W-19272/OE-7800', N'LM41-3', CAST(N'2024-07-19T15:53:55.6500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (370, N'6W-17224/OE-8400', N'F37-2', CAST(N'2024-07-19T15:53:55.6900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (371, N'6W-17735/OS-15000', N'DSSWM03', CAST(N'2024-07-19T15:53:55.7300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (372, N'6W-17848/OS-19500', N'HMDC-F', CAST(N'2024-07-19T15:53:55.7800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (373, N'6W-10803-OM/OS-22000', N'AMCF-US', CAST(N'2024-07-19T15:53:55.8200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (374, N'6W-17841/OS-24800', N'FMDF-03', CAST(N'2024-07-19T15:53:55.8600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (375, N'6W-9396/OS-28600', N'AMEF69-1', CAST(N'2024-07-19T15:53:55.8900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (376, N'FS-3725/OS-37700', N'UCM', CAST(N'2024-07-19T15:53:55.9300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (377, N'6W-12264/OS-4200', N'FMDF', CAST(N'2024-07-19T15:53:55.9700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (378, N'6W-2434/OS-4300', N'FMDF-03', CAST(N'2024-07-19T15:53:56.0100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (379, N'6W-16989/OS-44700', N'SLCNW-F', CAST(N'2024-07-19T15:53:56.0400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (380, N'6W-19279/OS-44700', N'SLCNW-F', CAST(N'2024-07-19T15:53:56.0800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (382, N'6W-17751/OS-50200', N'SNS-F03', CAST(N'2024-07-19T15:54:11.3700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (383, N'6W-17750/OS-50300', N'SNS-F', CAST(N'2024-07-19T15:54:11.4300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (384, N'6W-17807/OS-53400', N'PB901', CAST(N'2024-07-19T15:54:11.4800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (385, N'6W-16986/OS-55700', N'JMX5PAF03', CAST(N'2024-07-19T15:54:11.5300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (386, N'6W-18392/OS-58700', N'NMQSF999-1', CAST(N'2024-07-19T15:54:11.5700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (387, N'6W-17298/OS-58700', N'NMQSF999-1', CAST(N'2024-07-19T15:54:11.6100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (388, N'6W-17745/OS-5900', N'FMDF-20', CAST(N'2024-07-19T15:54:11.6400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (389, N'6W-10040/OS-59500', N'YOMA-F', CAST(N'2024-07-19T15:54:11.6800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (390, N'6W-17873/OS-6000', N'STWAF125', CAST(N'2024-07-19T15:54:11.7200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (391, N'6W-18197/OS-66300', N'AMEF68-1', CAST(N'2024-07-19T15:54:11.7600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (392, N'6W-18143/OS-71300', N'F990-2', CAST(N'2024-07-19T15:54:11.8000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (393, N'6W-17749/OS-74000', N'HMDC-F', CAST(N'2024-07-19T15:54:11.8300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (394, N'6W-17227/OS-76500', N'YOS-M', CAST(N'2024-07-19T15:54:11.8700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (395, N'6W-18416/OS-78200', N'JMX5AF20-P', CAST(N'2024-07-19T15:54:11.9100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (396, N'6W-19268/OS-79100', N'STDCF-189', CAST(N'2024-07-19T15:54:11.9500000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (397, N'6W-17380/OS-8000', N'STWAF', CAST(N'2024-07-19T15:54:11.9800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (398, N'6W-19265/OS-82700', N'RSSF-1', CAST(N'2024-07-19T15:54:12.0200000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (399, N'6W-17748/OS-84800', N'M343-2', CAST(N'2024-07-19T15:54:12.0700000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (400, N'6W-19736/OS-87300', N'MKYM20', CAST(N'2024-07-19T15:54:12.1100000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (401, N'FS-3702/OS-89700', N'JMX36-F-2', CAST(N'2024-07-19T15:54:12.1400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (402, N'FS-9826/FS-41200', N'JMX60-F', CAST(N'2024-07-19T15:54:12.1800000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (403, N'6W-9729/FS-41200', N'JMX60-F', CAST(N'2024-07-19T15:54:12.2200000' AS DateTime2))
GO
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (404, N'6W-17572/FS-41200', N'JMX60-F', CAST(N'2024-07-19T15:54:12.2600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (405, N'FS-13015/FS-75700', N'JMX60P-F', CAST(N'2024-07-19T15:54:12.2900000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (406, N'FS-5685/FS-67300', N'MKISOF', CAST(N'2024-07-19T15:54:12.3300000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (407, N'6W-17288/OE-28500', N'F222', CAST(N'2024-07-19T15:54:12.3600000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (408, N'6W-4457-OM/OE-28500', N'F222', CAST(N'2024-07-19T15:54:12.4000000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (409, N'FS-1263/OS-6100', N'AMCF', CAST(N'2024-07-19T15:54:12.4400000' AS DateTime2))
INSERT [dbo].[m_applicator_terminal] ([id], [applicator_no], [terminal_name], [date_updated]) VALUES (410, N'6W-17736/OS-6100', N'AMCF', CAST(N'2024-07-19T15:54:12.4700000' AS DateTime2))
SET IDENTITY_INSERT [dbo].[m_applicator_terminal] OFF
GO
SET IDENTITY_INSERT [dbo].[m_terminal] ON 

INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (4, N'ABD-F', N'S03A1', CAST(N'2024-07-19T15:56:35.2800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (5, N'ABD-F', N'S03A2', CAST(N'2024-07-19T15:56:35.3200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (6, N'AG-50', N'S03A3', CAST(N'2024-07-19T15:56:35.3600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (7, N'AG-50', N'S03A4', CAST(N'2024-07-19T15:56:35.4000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (8, N'ANSSF55-2', N'S03A5', CAST(N'2024-07-19T15:56:35.4400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (9, N'AMCF', N'S03A6', CAST(N'2024-07-19T15:56:35.4800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (10, N'APACF41-2', N'S03A7', CAST(N'2024-07-19T15:56:35.5200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (11, N'APACF41-2', N'S03A8', CAST(N'2024-07-19T15:56:35.5500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (12, N'ALEF33-2', N'S03A9', CAST(N'2024-07-19T15:56:35.5900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (13, N'ALEF32-1', N'S03A10', CAST(N'2024-07-19T15:56:35.6300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (14, N'ALEM37-2', N'S03A11', CAST(N'2024-07-19T15:56:35.6700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (15, N'ALEF37-2', N'S03A12', CAST(N'2024-07-19T15:56:35.7100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (16, N'AMEF68-1', N'S03A13', CAST(N'2024-07-19T15:56:35.7400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (17, N'AMCF-US', N'S03A14', CAST(N'2024-07-19T15:56:35.7800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (18, N'ANSSF55-1', N'S03A15', CAST(N'2024-07-19T15:56:35.8200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (19, N'ALCF094-US', N'S03A16', CAST(N'2024-07-19T15:56:35.8600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (20, N'AMEF69-1', N'S03A17', CAST(N'2024-07-19T15:56:35.9000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (21, N'ALCF', N'S03A18', CAST(N'2024-07-19T15:56:35.9400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (22, N'ASEF43-1', N'S03B1', CAST(N'2024-07-19T15:56:35.9800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (23, N'ASZF83-1', N'S03B2', CAST(N'2024-07-19T15:56:36.0100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (24, N'ASZF83-1', N'S03B3', CAST(N'2024-07-19T15:56:36.0500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (25, N'DHE-F', N'S03B4', CAST(N'2024-07-19T15:56:36.0900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (26, N'DHE-F03', N'S03B5', CAST(N'2024-07-19T15:56:36.1400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (27, N'F08-3E', N'S03B6', CAST(N'2024-07-19T15:56:36.1700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (28, N'F08-3E', N'S03B7', CAST(N'2024-07-19T15:56:36.2100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (29, N'DSWM03', N'S03B8', CAST(N'2024-07-19T15:56:36.2500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (30, N'DSWM', N'S03B9', CAST(N'2024-07-19T15:56:36.2800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (31, N'F18-3E', N'S03B10', CAST(N'2024-07-19T15:56:36.3400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (32, N'F37-2', N'S03B11', CAST(N'2024-07-19T15:56:36.4000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (33, N'DSSWM03', N'S03B12', CAST(N'2024-07-19T15:56:36.5100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (34, N'F990-2', N'S03B13', CAST(N'2024-07-19T15:56:36.5500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (35, N'FDSAF01', N'S03B14', CAST(N'2024-07-19T15:56:36.5800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (36, N'FDSAF01', N'S03B15', CAST(N'2024-07-19T15:56:36.6200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (37, N'FDSF', N'S03B16', CAST(N'2024-07-19T15:56:36.6600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (38, N'FDSF', N'S03B17', CAST(N'2024-07-19T15:56:36.7000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (39, N'FDSF', N'S03B18', CAST(N'2024-07-19T15:56:36.7300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (40, N'FDSF03', N'S03C1', CAST(N'2024-07-19T15:56:36.7700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (41, N'FDSF03', N'S03C2', CAST(N'2024-07-19T15:56:36.8500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (42, N'FDSF03', N'S03C3', CAST(N'2024-07-19T15:56:36.8900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (43, N'FDSF03', N'S03C4', CAST(N'2024-07-19T15:56:36.9300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (44, N'FDSF03', N'S03C5', CAST(N'2024-07-19T15:56:36.9600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (45, N'FDSF03', N'S03C6', CAST(N'2024-07-19T15:56:37.0000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (46, N'FDSF03', N'S03C7', CAST(N'2024-07-19T15:56:37.0600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (47, N'FDSM20', N'S03C8', CAST(N'2024-07-19T15:56:37.1000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (48, N'FDSM', N'S03C9', CAST(N'2024-07-19T15:56:37.1300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (49, N'FDSM', N'S03C10', CAST(N'2024-07-19T15:56:37.1700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (50, N'FKI-F', N'S03C11', CAST(N'2024-07-19T15:56:37.2100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (51, N'FDSM03', N'S03C12', CAST(N'2024-07-19T15:56:37.2400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (52, N'FDSWF', N'S03C13', CAST(N'2024-07-19T15:56:37.2800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (53, N'FDSWF', N'S03C14', CAST(N'2024-07-19T15:56:37.3200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (54, N'FDSF20', N'S03C15', CAST(N'2024-07-19T15:56:37.3500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (55, N'FDSF', N'S03C16', CAST(N'2024-07-19T15:56:37.3900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (56, N'FDSWF03', N'S03C17', CAST(N'2024-07-19T15:56:37.4300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (57, N'FDSWF03', N'S03C18', CAST(N'2024-07-19T15:56:37.4700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (58, N'FDSWF03-8', N'S03D1', CAST(N'2024-07-19T15:56:37.5100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (59, N'FDSWF03-8', N'S03D2', CAST(N'2024-07-19T15:56:37.5500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (60, N'FLEF36-1', N'S03D3', CAST(N'2024-07-19T15:56:37.5800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (61, N'FLEF36-1', N'S03D4', CAST(N'2024-07-19T15:56:37.6200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (62, N'FLEF36-1', N'S03D5', CAST(N'2024-07-19T15:56:37.6700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (63, N'FLEF36-1', N'S03D6', CAST(N'2024-07-19T15:56:37.7000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (64, N'HGT25-F', N'S03D7', CAST(N'2024-07-19T15:56:37.7400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (65, N'FMDF-03', N'S03D8', CAST(N'2024-07-19T15:56:37.7800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (66, N'FLEM37-1', N'S03D9', CAST(N'2024-07-19T15:56:37.8100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (67, N'HSEF03', N'S03D10', CAST(N'2024-07-19T15:56:37.8500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (68, N'FKI-F03', N'S03D11', CAST(N'2024-07-19T15:56:37.8900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (69, N'FKI-F03', N'S03D12', CAST(N'2024-07-19T15:56:37.9200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (70, N'FKI-F20', N'S03D13', CAST(N'2024-07-19T15:56:37.9600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (71, N'HMDC-F', N'S03D14', CAST(N'2024-07-19T15:56:38.0000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (72, N'FMDF', N'S03D15', CAST(N'2024-07-19T15:56:38.0400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (73, N'FLEF01', N'S03D16', CAST(N'2024-07-19T15:56:38.0700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (74, N'FLEF01', N'S03D17', CAST(N'2024-07-19T15:56:38.1100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (75, N'FMDF-20', N'S03D18', CAST(N'2024-07-19T15:56:38.1500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (76, N'JSNF01', N'S03E1', CAST(N'2024-07-19T15:56:38.1800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (77, N'JSNF01', N'S03E2', CAST(N'2024-07-19T15:56:38.2200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (78, N'JMX36-F-2', N'S03E3', CAST(N'2024-07-19T15:56:38.2600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (79, N'JSNF03', N'S03E4', CAST(N'2024-07-19T15:56:38.2900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (80, N'JSNF03', N'S03E5', CAST(N'2024-07-19T15:56:38.3300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (81, N'JSNF03', N'S03E6', CAST(N'2024-07-19T15:56:38.3700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (82, N'JMX5PAF03', N'S03E7', CAST(N'2024-07-19T15:56:38.4000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (83, N'JMX5AF-P', N'S03E8', CAST(N'2024-07-19T15:56:38.4400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (84, N'JMX37-F03', N'S03E9', CAST(N'2024-07-19T15:56:38.4800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (85, N'JMX5AF20-P', N'S03E10', CAST(N'2024-07-19T15:56:38.5200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (86, N'JMX37-F', N'S03E11', CAST(N'2024-07-19T15:56:38.5500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (87, N'JMX37-F', N'S03E12', CAST(N'2024-07-19T15:56:38.5900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (88, N'HZE05-F', N'S03E13', CAST(N'2024-07-19T15:56:38.6200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (89, N'JSNF', N'S03E14', CAST(N'2024-07-19T15:56:38.6600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (90, N'JSNF', N'S03E15', CAST(N'2024-07-19T15:56:38.7000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (91, N'FDSWF-8', N'S03E16', CAST(N'2024-07-19T15:56:38.7400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (92, N'JMX5AF-S', N'S03E17', CAST(N'2024-07-19T15:56:38.7700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (93, N'JMX5AF-S', N'S03E18', CAST(N'2024-07-19T15:56:38.8100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (94, N'MAF-YTA10', N'S03F1', CAST(N'2024-07-19T15:56:38.8500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (95, N'MAF-10E', N'S03F2', CAST(N'2024-07-19T15:56:38.8800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (96, N'MAF-YTA11', N'S03F3', CAST(N'2024-07-19T15:56:38.9200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (97, N'MAF-12E', N'S03F4', CAST(N'2024-07-19T15:56:38.9500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (98, N'MAF-11E', N'S03F5', CAST(N'2024-07-19T15:56:38.9900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (99, N'MAF-STA11', N'S03F6', CAST(N'2024-07-19T15:56:39.0200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (100, N'JSNF03', N'S03F7', CAST(N'2024-07-19T15:56:39.0600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (101, N'JSNF03', N'S03F8', CAST(N'2024-07-19T15:56:39.1000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (102, N'JSNF03', N'S03F9', CAST(N'2024-07-19T15:56:39.1300000' AS DateTime2))
GO
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (103, N'LIFM-F', N'S03F10', CAST(N'2024-07-19T15:56:39.1700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (104, N'MATF144-1', N'S03F11', CAST(N'2024-07-19T15:56:39.2100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (105, N'SNH-M01LI', N'S03F12', CAST(N'2024-07-19T15:56:39.2400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (106, N'M727-2', N'S03F13', CAST(N'2024-07-19T15:56:39.2800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (107, N'LM41-3', N'S03F14', CAST(N'2024-07-19T15:56:39.3200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (108, N'M343-2', N'S03F15', CAST(N'2024-07-19T15:56:39.3500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (109, N'MAF-YTA12', N'S03F16', CAST(N'2024-07-19T15:56:39.3900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (110, N'MCCF', N'S03F17', CAST(N'2024-07-19T15:56:39.4200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (111, N'JWPFM', N'S03F18', CAST(N'2024-07-19T15:56:39.4600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (112, N'MKF20', N'S03G1', CAST(N'2024-07-19T15:56:39.5000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (113, N'MKF20', N'S03G2', CAST(N'2024-07-19T15:56:39.5300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (114, N'MKF20', N'S03G3', CAST(N'2024-07-19T15:56:39.5700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (115, N'SNH-FLI', N'S03G4', CAST(N'2024-07-19T15:56:39.6100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (116, N'MKF20E', N'S03G5', CAST(N'2024-07-19T15:56:39.6400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (117, N'MKSF03', N'S03G6', CAST(N'2024-07-19T15:56:39.6800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (118, N'MKF03', N'S03G7', CAST(N'2024-07-19T15:56:39.7200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (119, N'MKF03', N'S03G8', CAST(N'2024-07-19T15:56:39.7500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (120, N'MKSF', N'S03G9', CAST(N'2024-07-19T15:56:39.7900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (121, N'MPQNWF75-2', N'S03G10', CAST(N'2024-07-19T15:56:39.8200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (122, N'MKYM20', N'S03G11', CAST(N'2024-07-19T15:56:39.8600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (123, N'MKM20', N'S03G12', CAST(N'2024-07-19T15:56:39.9000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (124, N'MKYF20', N'S03G13', CAST(N'2024-07-19T15:56:39.9300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (125, N'MKSF20', N'S03G14', CAST(N'2024-07-19T15:56:39.9700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (126, N'MQSF969-18', N'S03G15', CAST(N'2024-07-19T15:56:40.0000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (127, N'MQSF969-18', N'S03G16', CAST(N'2024-07-19T15:56:40.0400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (128, N'MQSF969-1', N'S03G17', CAST(N'2024-07-19T15:56:40.0800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (129, N'MQSF969-1', N'S03G18', CAST(N'2024-07-19T15:56:40.1200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (130, N'RSSF-1', N'S03H1', CAST(N'2024-07-19T15:56:40.1500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (131, N'NRSSF', N'S03H2', CAST(N'2024-07-19T15:56:40.1900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (132, N'NASZF11-1', N'S03H3', CAST(N'2024-07-19T15:56:40.2200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (133, N'NASZF11-1', N'S03H4', CAST(N'2024-07-19T15:56:40.2600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (134, N'NASZF11-1', N'S03H5', CAST(N'2024-07-19T15:56:40.3000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (135, N'MX06-F1039', N'S03H6', CAST(N'2024-07-19T15:56:40.3300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (136, N'SNH-F01LI', N'S03H7', CAST(N'2024-07-19T15:56:40.3700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (137, N'MTL-F', N'S03H8', CAST(N'2024-07-19T15:56:40.4100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (138, N'MX06-F10398', N'S03H9', CAST(N'2024-07-19T15:56:40.4400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (139, N'MKF', N'S03H10', CAST(N'2024-07-19T15:56:40.4800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (140, N'PCF20', N'S03H11', CAST(N'2024-07-19T15:56:40.5200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (141, N'PB901', N'S03H12', CAST(N'2024-07-19T15:56:40.5500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (142, N'MX15-F10298', N'S03H13', CAST(N'2024-07-19T15:56:40.5900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (143, N'NMQSF999-1', N'S03H14', CAST(N'2024-07-19T15:56:40.6300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (144, N'NTYF', N'S03H15', CAST(N'2024-07-19T15:56:40.6700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (145, N'NTF', N'S03H16', CAST(N'2024-07-19T15:56:40.7000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (146, N'SLCNW-F', N'S03H17', CAST(N'2024-07-19T15:56:40.7400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (147, N'SLCNW-F', N'S03H18', CAST(N'2024-07-19T15:56:40.7700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (148, N'SSEWM', N'S03I1', CAST(N'2024-07-19T15:56:40.8100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (149, N'SSEWM', N'S03I2', CAST(N'2024-07-19T15:56:40.8500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (150, N'SSGF', N'S03I3', CAST(N'2024-07-19T15:56:40.8900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (151, N'SSGF', N'S03I4', CAST(N'2024-07-19T15:56:40.9300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (152, N'SSGF', N'S03I5', CAST(N'2024-07-19T15:56:40.9700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (153, N'SSGF', N'S03I6', CAST(N'2024-07-19T15:56:41.0100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (154, N'SSGF', N'S03I7', CAST(N'2024-07-19T15:56:41.0900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (155, N'SSGF', N'S03I8', CAST(N'2024-07-19T15:56:41.1200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (156, N'SSGF', N'S03I9', CAST(N'2024-07-19T15:56:41.1700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (157, N'SSEWM-8', N'S03I10', CAST(N'2024-07-19T15:56:41.2100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (158, N'SNH-MLI', N'S03I11', CAST(N'2024-07-19T15:56:41.2500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (159, N'SNS-F03', N'S03I12', CAST(N'2024-07-19T15:56:41.2900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (160, N'SNS-F', N'S03I13', CAST(N'2024-07-19T15:56:41.3200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (161, N'SSEWF', N'S03I14', CAST(N'2024-07-19T15:56:41.3600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (162, N'SSEWF', N'S03I15', CAST(N'2024-07-19T15:56:41.4000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (163, N'STWAF075', N'S03I16', CAST(N'2024-07-19T15:56:41.4300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (164, N'SSEWF05', N'S03I17', CAST(N'2024-07-19T15:56:41.4700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (165, N'SSEWF-8', N'S03I18', CAST(N'2024-07-19T15:56:41.5000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (166, N'SSGF01', N'S03J1', CAST(N'2024-07-19T15:56:41.5400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (167, N'SSGF01', N'S03J2', CAST(N'2024-07-19T15:56:41.5800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (168, N'SSGF01', N'S03J3', CAST(N'2024-07-19T15:56:41.6100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (169, N'SSGF01', N'S03J4', CAST(N'2024-07-19T15:56:41.6500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (170, N'SSGF-8AB', N'S03J5', CAST(N'2024-07-19T15:56:41.6800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (171, N'SSGF-8', N'S03J6', CAST(N'2024-07-19T15:56:41.7200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (172, N'SSGM01', N'S03J7', CAST(N'2024-07-19T15:56:41.7600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (173, N'SSGM01', N'S03J8', CAST(N'2024-07-19T15:56:41.7900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (174, N'SSGM', N'S03J9', CAST(N'2024-07-19T15:56:41.8300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (175, N'SSGM', N'S03J10', CAST(N'2024-07-19T15:56:41.8600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (176, N'SSGM', N'S03J11', CAST(N'2024-07-19T15:56:41.9000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (177, N'SSGM', N'S03J12', CAST(N'2024-07-19T15:56:41.9400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (178, N'SSGM', N'S03J13', CAST(N'2024-07-19T15:56:41.9700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (179, N'SSGF', N'S03J14', CAST(N'2024-07-19T15:56:42.0100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (180, N'SSGF', N'S03J15', CAST(N'2024-07-19T15:56:42.0400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (181, N'SSGF', N'S03J16', CAST(N'2024-07-19T15:56:42.0800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (182, N'STDCF', N'S03J17', CAST(N'2024-07-19T15:56:42.1200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (183, N'STDCF-03', N'S03J18', CAST(N'2024-07-19T15:56:42.1500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (184, N'STWF125', N'S03K1', CAST(N'2024-07-19T15:56:42.1900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (185, N'TSN-F01', N'S03K2', CAST(N'2024-07-19T15:56:42.2200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (186, N'STWAF125', N'S03K3', CAST(N'2024-07-19T15:56:42.2600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (187, N'STWAF', N'S03K4', CAST(N'2024-07-19T15:56:42.3000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (188, N'SWJCF085', N'S03K5', CAST(N'2024-07-19T15:56:42.3400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (189, N'STDCF-189', N'S03K6', CAST(N'2024-07-19T15:56:42.3800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (190, N'TSN-F03', N'S03K7', CAST(N'2024-07-19T15:56:42.4100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (191, N'TSN-F03', N'S03K8', CAST(N'2024-07-19T15:56:42.4500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (192, N'STWM', N'S03K9', CAST(N'2024-07-19T15:56:42.4800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (193, N'STDCM-105', N'S03K10', CAST(N'2024-07-19T15:56:42.5200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (194, N'STDCM-03', N'S03K11', CAST(N'2024-07-19T15:56:42.5500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (195, N'STDCM', N'S03K12', CAST(N'2024-07-19T15:56:42.5900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (196, N'SSEWF05-8', N'S03K13', CAST(N'2024-07-19T15:56:42.6300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (197, N'SWJCF', N'S03K14', CAST(N'2024-07-19T15:56:42.6600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (198, N'TSN-F', N'S03K15', CAST(N'2024-07-19T15:56:42.7000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (199, N'TSN-F', N'S03K16', CAST(N'2024-07-19T15:56:42.7300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (200, N'TSN-F', N'S03K17', CAST(N'2024-07-19T15:56:42.7700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (201, N'STWF075', N'S03K18', CAST(N'2024-07-19T15:56:42.8100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (202, N'TSNY-F', N'S03L1', CAST(N'2024-07-19T15:56:42.8400000' AS DateTime2))
GO
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (203, N'TSN-M20', N'S03L2', CAST(N'2024-07-19T15:56:42.8800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (204, N'TSNY-F03', N'S03L3', CAST(N'2024-07-19T15:56:42.9100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (205, N'TSN-F03', N'S03L4', CAST(N'2024-07-19T15:56:42.9500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (206, N'TSN-F03', N'S03L5', CAST(N'2024-07-19T15:56:42.9800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (207, N'TSN-F03', N'S03L6', CAST(N'2024-07-19T15:56:43.0200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (208, N'TSN-M03', N'S03L7', CAST(N'2024-07-19T15:56:43.0600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (209, N'TSN-M03', N'S03L8', CAST(N'2024-07-19T15:56:43.0900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (210, N'TSN-M', N'S03L9', CAST(N'2024-07-19T15:56:43.1300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (211, N'TSN-M', N'S03L10', CAST(N'2024-07-19T15:56:43.1600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (212, N'TSNY-M', N'S03L11', CAST(N'2024-07-19T15:56:43.2000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (213, N'TSNY-M03', N'S03L12', CAST(N'2024-07-19T15:56:43.2300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (214, N'YOMA-F', N'S03L13', CAST(N'2024-07-19T15:56:43.2700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (215, N'WPCF03', N'S03L14', CAST(N'2024-07-19T15:56:43.3000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (216, N'YECPF075', N'S03L15', CAST(N'2024-07-19T15:56:43.3400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (217, N'UCM', N'S03L16', CAST(N'2024-07-19T15:56:43.3800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (218, N'TSN-F20', N'S03L17', CAST(N'2024-07-19T15:56:43.4100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (219, N'TSN-F20', N'S03L18', CAST(N'2024-07-19T15:56:43.4500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (220, N'YSN-F20', N'S03M1', CAST(N'2024-07-19T15:56:43.4800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (221, N'YSN-F', N'S03M2', CAST(N'2024-07-19T15:56:43.5200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (222, N'YRHF03', N'S03M3', CAST(N'2024-07-19T15:56:43.5600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (223, N'YRHF03', N'S03M4', CAST(N'2024-07-19T15:56:43.5900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (224, N'YSN-M20', N'S03M5', CAST(N'2024-07-19T15:56:43.6300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (225, N'YSKF', N'S03M6', CAST(N'2024-07-19T15:56:43.6700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (226, N'YSN-F03', N'S03M7', CAST(N'2024-07-19T15:56:43.7000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (227, N'YSN-F03', N'S03M8', CAST(N'2024-07-19T15:56:43.7400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (228, N'YOS-F', N'S03M9', CAST(N'2024-07-19T15:56:43.7700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (229, N'YSN-M', N'S03M10', CAST(N'2024-07-19T15:56:43.8100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (230, N'YPSF-1', N'S03M11', CAST(N'2024-07-19T15:56:43.8500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (231, N'YSN-F01', N'S03M12', CAST(N'2024-07-19T15:56:43.8800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (232, N'YSN-M03', N'S03M13', CAST(N'2024-07-19T15:56:43.9200000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (233, N'YSKM', N'S03M14', CAST(N'2024-07-19T15:56:43.9500000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (234, N'YSKM', N'S03M15', CAST(N'2024-07-19T15:56:43.9900000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (235, N'YSKM03', N'S03M16', CAST(N'2024-07-19T15:56:44.0300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (236, N'YRHF', N'S03M17', CAST(N'2024-07-19T15:56:44.0600000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (237, N'YOS-M', N'S03M18', CAST(N'2024-07-19T15:56:44.1000000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (238, N'PB52-2', N'S03N1', CAST(N'2024-07-19T15:56:44.1300000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (239, N'PB54-2', N'S03N2', CAST(N'2024-07-19T15:56:44.1700000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (240, N'PB54-1', N'S03N3', CAST(N'2024-07-19T15:56:44.2100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (241, N'PB213-2', N'S03N4', CAST(N'2024-07-19T15:56:44.2400000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (242, N'F84-1', N'S03N5', CAST(N'2024-07-19T15:56:44.2800000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (243, N'F84-2', N'S03N6', CAST(N'2024-07-19T15:56:44.3100000' AS DateTime2))
INSERT [dbo].[m_terminal] ([id], [terminal_name], [line_address], [date_updated]) VALUES (244, N'F32-5', N'S03N7', CAST(N'2024-07-19T15:56:44.3500000' AS DateTime2))
SET IDENTITY_INSERT [dbo].[m_terminal] OFF
GO
SET IDENTITY_INSERT [dbo].[t_applicator_c] ON 

INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (1, N'MEI-295-AC-240708071d762', N'TEST1', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'1900-01-01T00:00:00.0000000' AS DateTime2), N'DS', N'', 1, N'Alcantara, Vince Dale D.', N'', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL)
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (2, N'MEI-295-AC-240708090d3a8', N'TEST2', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'1900-01-01T00:00:00.0000000' AS DateTime2), N'DS', N'ALL GOOD', 1, N'Alcantara, Vince Dale D.', N'22-08675', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL)
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (3, N'MEI-295-AC-2407080986d86', N'TEST3', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-08T09:49:14.0000000' AS DateTime2), N'DS', N'ALL GOOD', 1, N'Alcantara, Vince Dale D.', N'22-08675', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL)
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (4, N'MEI-295-AC-24070801c4446', N'TEST4', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-08T13:52:24.0000000' AS DateTime2), N'DS', N'TEST4', 3, N'Alcantara, Vince Dale D.', N'22-08675', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 2, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 3, NULL, NULL, 4, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL)
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (5, N'MEI-295-AC-24070908e2f06', N'TEST5', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-10T07:15:48.0000000' AS DateTime2), N'DS', N'Last Test For AC', 1, N'Alcantara, Vince Dale D.', N'22-08675', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 2, NULL, NULL, 3, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 4, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL)
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (6, N'MEI-295-AC-240710083da29', N'TEST6', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-10T11:08:38.0000000' AS DateTime2), N'DS', N'TEST ON INPSECTOR INTERFACE', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL)
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (7, N'MEI-295-AC-2407100151c98', N'TEST7', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-10T14:57:56.0000000' AS DateTime2), N'DS', N'TEST FOR TRIANGLE AND X', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 2, N'', N'', 2, N'', N'', 2, N'', N'', 2, N'', N'', 2, N'', N'', 3, N'', N'', 3, N'', N'', 3, N'', N'', 3, N'', N'', 3, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (8, N'MEI-295-AC-2407100444b6e', N'TEST8', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-10T16:20:31.0000000' AS DateTime2), N'DS', N'TEST AGAIN', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 2, N'Repair/Adjust', N'', 2, N'Clean', N'', 2, N'Repair/Adjust', N'', 2, N'Clean', N'', 2, N'Clean', N'', 3, N'', N'rd6', 3, N'', N'rd7', 3, N'', N'rd8', 3, N'', N'rd9', 3, N'', N'rd10')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (9, N'MEI-295-AC-24071004bc24c', N'TEST9', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-10T16:43:17.0000000' AS DateTime2), N'DS', N'TEST AGAIN 2', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 2, N'Repair/Adjust', N'', 2, N'Clean', N'', 2, N'Repair/Adjust', N'', 2, N'Clean', N'', 2, N'Repair/Adjust', N'', 3, N'Replace', N'rd6', 3, N'Replace', N'rd7', 3, N'Replace', N'rd8', 3, N'Replace', N'rd9', 3, N'Replace', N'rd10')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (10, N'MEI-295-AC-24071107a8aca', N'TEST10', N'AO-14016/565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-11T07:18:00.0000000' AS DateTime2), N'DS', N'TEST AGAIN 3', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 2, N'Repair/Adjust', N'', 2, N'Clean', N'', 2, N'Repair/Adjust', N'', 2, N'Clean', N'', 1, N'', N'', 3, N'Replace', N'rd6', 3, N'Replace', N'rd7', 3, N'Replace', N'rd8', 3, N'Replace', N'rd9', 1, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (11, N'MEI-295-AC-24071107a1861', N'TEST11', N'AO-14016/565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-11T07:23:14.0000000' AS DateTime2), N'DS', N'TEST 4', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 2, N'Repair/Adjust', N'', 2, N'Clean', N'', 3, N'Replace', N'rd3', 1, N'', N'', 1, N'', N'', 4, N'', N'', 3, N'Replace', N'rd7', 2, N'Clean', N'', 2, N'Repair/Adjust', N'', 1, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (12, N'MEI-295-AC-240711077d506', N'TEST12', N'', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-11T07:53:26.0000000' AS DateTime2), N'DS', N'', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 4, N'', N'', 4, N'', N'', 4, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (15, N'MEI-295-AC-2407110745c64', N'TEST13', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-11T07:55:58.0000000' AS DateTime2), N'DS', N'', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 4, N'', N'', 4, N'', N'', 4, N'', N'', 4, N'', N'', 4, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (16, N'MEI-295-AC-240711085b50e', N'TEST14', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-11T08:37:52.0000000' AS DateTime2), N'DS', N'', 1, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (17, N'MEI-295-AC-24071105c2d3e', N'6W-17366', N'OE-23000', N'PS-017-2', N'Zaihai-02', N'S03A2', CAST(N'2024-07-11T17:36:54.0000000' AS DateTime2), N'DS', N'', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (18, N'MEI-295-AC-24071207d17df', N'AO-13005', N'553800', N'PS-800-2', N'Zaihai-03', N'S03A3', CAST(N'2024-07-12T07:20:37.0000000' AS DateTime2), N'DS', N'', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 2, N'Repair/Adjust', N'R1', 2, N'Repair/Adjust', N'R2', 2, N'Repair/Adjust', N'R3', 2, N'Repair/Adjust', N'R4', 2, N'Repair/Adjust', N'R5', 2, N'Repair/Adjust', N'R6', 2, N'Repair/Adjust', N'R7', 2, N'Repair/Adjust', N'R8', 2, N'Repair/Adjust', N'R9', 2, N'Repair/Adjust', N'R10')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (19, N'MEI-295-AC-240711094c12a', N'AO-14016', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-13T08:11:08.0000000' AS DateTime2), N'DS', N'', 4, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (20, N'MEI-295-AC-240718053b93e', N'AO-14016', N'565200', N'PS-200-2', N'Zaihai-01', N'S03A1', CAST(N'2024-07-18T17:18:33.0000000' AS DateTime2), N'DS', N'', 1, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (21, N'MEI-295-AC-240719049f18f', N'FS-4400', N'FS-100', N'FDSF03', N'R1-2', N'S03C2', CAST(N'2024-07-19T16:06:52.0000000' AS DateTime2), N'DS', N'', 1, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'')
INSERT [dbo].[t_applicator_c] ([id], [serial_no], [equipment_no], [machine_no], [terminal_name], [zaihai_stock_address], [line_address], [inspection_date_time], [inspection_shift], [adjustment_content], [cross_section_result], [inspected_by], [inspected_by_no], [checked_by], [checked_by_no], [confirmed_by], [confirmed_by_no], [judgement], [ac1], [ac1_s], [ac1_r], [ac2], [ac2_s], [ac2_r], [ac3], [ac3_s], [ac3_r], [ac4], [ac4_s], [ac4_r], [ac5], [ac5_s], [ac5_r], [ac6], [ac6_s], [ac6_r], [ac7], [ac7_s], [ac7_r], [ac8], [ac8_s], [ac8_r], [ac9], [ac9_s], [ac9_r], [ac10], [ac10_s], [ac10_r]) VALUES (22, N'MEI-295-AC-240719042be83', N'FS-11200', N'FS-100', N'FDSF03', N'R1-1', N'S03C7', CAST(N'2024-07-19T16:07:20.0000000' AS DateTime2), N'DS', N'', 1, N'Inpector1', N'24-00000', NULL, NULL, NULL, NULL, NULL, 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'', 1, N'', N'')
SET IDENTITY_INSERT [dbo].[t_applicator_c] OFF
GO
SET IDENTITY_INSERT [dbo].[t_applicator_in_out_history] ON 

INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (1, N'MEI-295-AC-24070605c5cc1', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-06T17:01:48.3100000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-06T17:25:50.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (2, N'MEI-295-AC-24070605cec9d', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-06T17:26:50.4100000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-06T17:27:03.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (3, N'MEI-295-AC-240706057dcef', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-06T17:48:20.1200000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-06T17:48:34.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (4, N'MEI-295-AC-240708071d762', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-08T07:28:44.8800000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-08T09:15:18.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (5, N'MEI-295-AC-240708090d3a8', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-08T09:45:30.4200000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-08T09:46:16.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (6, N'MEI-295-AC-2407080986d86', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-08T09:48:59.2700000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-08T09:49:53.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (7, N'MEI-295-AC-24070801c4446', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-08T13:50:40.3200000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-08T13:55:25.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (8, N'MEI-295-AC-24070908e2f06', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-09T08:35:22.0200000' AS DateTime2), N'Zaihai-01', N'22-08675', CAST(N'2024-07-10T07:16:22.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (9, N'MEI-295-AC-240710083da29', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-10T08:44:18.1700000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-10T11:09:39.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (10, N'MEI-295-AC-2407100151c98', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-10T13:40:20.1700000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-10T14:59:18.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (11, N'MEI-295-AC-2407100444b6e', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-10T16:19:08.2800000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-10T16:21:32.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (12, N'MEI-295-AC-24071004bc24c', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-10T16:42:49.0600000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-10T16:44:19.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (13, N'MEI-295-AC-24071107a8aca', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-11T07:15:28.3700000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-11T07:19:16.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (14, N'MEI-295-AC-24071107a1861', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-11T07:21:37.6200000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-11T07:24:19.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (15, N'MEI-295-AC-240711077d506', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-11T07:52:53.7800000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-11T07:53:55.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (16, N'MEI-295-AC-2407110745c64', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-11T07:55:27.9300000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-11T07:56:30.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (17, N'MEI-295-AC-240711085b50e', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-11T08:36:52.7700000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-11T08:38:14.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (18, N'MEI-295-AC-24071105c2d3e', N'6W-17366/OE-23000', N'PS-017-2*0*S0802 0148C', N'TRD111', N'22-08675', CAST(N'2024-07-11T17:30:49.5500000' AS DateTime2), N'Zaihai-02', N'24-00000', CAST(N'2024-07-11T17:41:09.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (19, N'MEI-295-AC-24071207d17df', N'AO-13005/553800', N'PS-800-2**S0N190523406', N'TRD333', N'22-08675', CAST(N'2024-07-12T07:20:12.1500000' AS DateTime2), N'Zaihai-03', N'24-00000', CAST(N'2024-07-12T07:42:50.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (20, N'MEI-295-AC-240711094c12a', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-11T09:09:33.0400000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-13T08:11:22.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (21, N'MEI-295-AC-240718053b93e', N'AO-14016/565200', N'PS-200-2**s0n200526410', N'TRD222', N'22-08675', CAST(N'2024-07-18T17:15:10.6600000' AS DateTime2), N'Zaihai-01', N'24-00000', CAST(N'2024-07-18T17:19:10.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (22, N'MEI-295-AC-240719049f18f', N'FS-4400/FS-100', N'FDSF03*', N'SUZ_TRD327_R2', N'22-08675', CAST(N'2024-07-19T16:05:47.4900000' AS DateTime2), N'R1-2', N'24-00000', CAST(N'2024-07-19T16:07:18.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_in_out_history] ([id], [serial_no], [applicator_no], [terminal_name], [trd_no], [operator_out], [date_time_out], [zaihai_stock_address], [operator_in], [date_time_in]) VALUES (23, N'MEI-295-AC-240719042be83', N'FS-11200/FS-100', N'FDSF03*', N'SUZ_TRD327_R1', N'22-08675', CAST(N'2024-07-19T16:05:19.9600000' AS DateTime2), N'R1-1', N'24-00000', CAST(N'2024-07-19T16:07:53.0000000' AS DateTime2))
SET IDENTITY_INSERT [dbo].[t_applicator_in_out_history] OFF
GO
SET IDENTITY_INSERT [dbo].[t_applicator_list] ON 

INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (411, N'Suzuki', N'YV7', N'FS-11200/FS-100', N'R1-1', N'Ready To Use', CAST(N'2024-07-19T16:07:53.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (412, N'Suzuki', N'YV7', N'FS-4400/FS-100', N'R1-2', N'Ready To Use', CAST(N'2024-07-19T16:07:18.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (413, N'Suzuki', N'YV7', N'FS-11192/FS-100', N'R1-3', N'Ready To Use', CAST(N'2024-07-19T15:51:24.0100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (414, N'Suzuki', N'YV7', N'FS-3451/FS-100', N'R1-4', N'Ready To Use', CAST(N'2024-07-19T15:51:24.0500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (415, N'Suzuki', N'YV7', N'6W-12705/FS-100', N'R1-5', N'Ready To Use', CAST(N'2024-07-19T15:51:24.0900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (416, N'Suzuki', N'YV7', N'FS-3689/FS-100', N'R1-6', N'Ready To Use', CAST(N'2024-07-19T15:51:24.1600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (417, N'Suzuki', N'YV7', N'FS-3336/FS-100', N'R1-7', N'Ready To Use', CAST(N'2024-07-19T15:51:24.2000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (418, N'Suzuki', N'YV7', N'FS-4686/FS-1000', N'R1-8', N'Ready To Use', CAST(N'2024-07-19T15:51:24.2400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (419, N'Suzuki', N'YV7', N'FS-4910/FS-10000', N'R1-9', N'Ready To Use', CAST(N'2024-07-19T15:51:24.2800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (420, N'Suzuki', N'YV7', N'FS-9572/FS-10300', N'R1-10', N'Ready To Use', CAST(N'2024-07-19T15:51:24.3100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (421, N'Suzuki', N'YV7', N'FS-3319/FS-10300', N'R1-11', N'Ready To Use', CAST(N'2024-07-19T15:51:24.3500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (422, N'Suzuki', N'YV7', N'FS-4864/FS-10300', N'R1-12', N'Ready To Use', CAST(N'2024-07-19T15:51:24.3900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (423, N'Suzuki', N'YV7', N'FS-14425/FS-105100', N'R1-13', N'Ready To Use', CAST(N'2024-07-19T15:51:24.4400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (424, N'Suzuki', N'YV7', N'6W-18739/FS-105600', N'R1-14', N'Ready To Use', CAST(N'2024-07-19T15:51:24.4800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (425, N'Suzuki', N'YV7', N'FS-4021/FS-10600', N'R1-15', N'Ready To Use', CAST(N'2024-07-19T15:51:24.5300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (426, N'Suzuki', N'YV7', N'FS-12997/FS-10600', N'R1-16', N'Ready To Use', CAST(N'2024-07-19T15:51:24.6000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (427, N'Suzuki', N'YV7', N'FS-4886/FS-10600', N'R1-17', N'Ready To Use', CAST(N'2024-07-19T15:51:24.6400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (428, N'Suzuki', N'YV7', N'FS-12995/FS-10600', N'R1-18', N'Ready To Use', CAST(N'2024-07-19T15:51:24.6800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (429, N'Suzuki', N'YV7', N'FS-3468/FS-10600', N'R1-19', N'Ready To Use', CAST(N'2024-07-19T15:51:24.7100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (430, N'Suzuki', N'YV7', N'FS-4303/FS-10600', N'R1-20', N'Ready To Use', CAST(N'2024-07-19T15:51:24.7500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (431, N'Suzuki', N'YV7', N'FS-4176/FS-10600', N'R1-21', N'Ready To Use', CAST(N'2024-07-19T15:51:24.7900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (432, N'Suzuki', N'YV7', N'FS-12996/FS-10600', N'R1-22', N'Ready To Use', CAST(N'2024-07-19T15:51:24.8200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (433, N'Suzuki', N'YV7', N'FS-4917/FS-10600', N'R1-23', N'Ready To Use', CAST(N'2024-07-19T15:51:24.8600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (434, N'Suzuki', N'YV7', N'FS-4335/FS-10600', N'R1-24', N'Ready To Use', CAST(N'2024-07-19T15:51:24.9300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (435, N'Suzuki', N'YV7', N'FS-4741/FS-10600', N'R1-25', N'Ready To Use', CAST(N'2024-07-19T15:51:24.9700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (436, N'Suzuki', N'YV7', N'FS-12999/FS-10700', N'R1-26', N'Ready To Use', CAST(N'2024-07-19T15:51:25.0100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (437, N'Suzuki', N'YV7', N'FS-4177/FS-10700', N'R1-27', N'Ready To Use', CAST(N'2024-07-19T15:51:25.0400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (438, N'Suzuki', N'YV7', N'FS-4766/FS-10700', N'R1-28', N'Ready To Use', CAST(N'2024-07-19T15:51:25.0800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (439, N'Suzuki', N'YV7', N'FS-13000/FS-10700', N'R1-29', N'Ready To Use', CAST(N'2024-07-19T15:51:25.1200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (440, N'Suzuki', N'YV7', N'FS-4338/FS-10700', N'R1-30', N'Ready To Use', CAST(N'2024-07-19T15:51:25.2400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (441, N'Suzuki', N'YV7', N'FS-5932/FS-10700', N'R1-31', N'Ready To Use', CAST(N'2024-07-19T15:51:25.2800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (442, N'Suzuki', N'YV7', N'FS-4887/FS-10700', N'R1-32', N'Ready To Use', CAST(N'2024-07-19T15:51:25.3100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (443, N'Suzuki', N'YV7', N'FS-4403/FS-10700', N'R1-33', N'Ready To Use', CAST(N'2024-07-19T15:51:25.3500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (444, N'Suzuki', N'YV7', N'FS-4790/FS-10700', N'R1-34', N'Ready To Use', CAST(N'2024-07-19T15:51:25.3900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (445, N'Suzuki', N'YV7', N'FS-5934/FS-10700', N'R1-35', N'Ready To Use', CAST(N'2024-07-19T15:51:25.4200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (446, N'Suzuki', N'YV7', N'FS-5703/FS-10700', N'R1-36', N'Ready To Use', CAST(N'2024-07-19T15:51:25.4600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (447, N'Suzuki', N'YV7', N'FS-9927/FS-10700', N'R1-37', N'Ready To Use', CAST(N'2024-07-19T15:51:25.5000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (448, N'Suzuki', N'YV7', N'FS-10556/FS-10700', N'R1-38', N'Ready To Use', CAST(N'2024-07-19T15:51:25.5400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (449, N'Suzuki', N'YV7', N'FS-10279/FS-10700', N'R1-39', N'Ready To Use', CAST(N'2024-07-19T15:51:25.5800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (450, N'Suzuki', N'YV7', N'FS-4163/FS-10700', N'R1-40', N'Ready To Use', CAST(N'2024-07-19T15:51:25.6100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (451, N'Suzuki', N'YV7', N'FS-4343/FS-11000', N'R2-1', N'Ready To Use', CAST(N'2024-07-19T15:51:25.6500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (452, N'Suzuki', N'YV7', N'FS-10192/FS-12700', N'R2-2', N'Ready To Use', CAST(N'2024-07-19T15:51:25.6900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (453, N'Suzuki', N'YV7', N'FS-3091/FS-13700', N'R2-3', N'Ready To Use', CAST(N'2024-07-19T15:51:25.7300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (454, N'Suzuki', N'YV7', N'FS-6755/FS-14400', N'R2-4', N'Ready To Use', CAST(N'2024-07-19T15:51:25.7600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (455, N'Suzuki', N'YV7', N'FS-4746/FS-14400', N'R2-5', N'Ready To Use', CAST(N'2024-07-19T15:51:25.8000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (456, N'Suzuki', N'YV7', N'FS-3696/FS-14600', N'R2-6', N'Ready To Use', CAST(N'2024-07-19T15:51:25.8400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (457, N'Suzuki', N'YV7', N'FS-13027/FS-14600', N'R2-7', N'Ready To Use', CAST(N'2024-07-19T15:51:25.8800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (458, N'Suzuki', N'YV7', N'FS-13948/FS-14600', N'R2-8', N'Ready To Use', CAST(N'2024-07-19T15:51:25.9600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (459, N'Suzuki', N'YV7', N'FS-13945/FS-14600', N'R2-9', N'Ready To Use', CAST(N'2024-07-19T15:51:26.0200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (460, N'Suzuki', N'YV7', N'FS-4282/FS-14700', N'R2-10', N'Ready To Use', CAST(N'2024-07-19T15:51:26.0500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (461, N'Suzuki', N'YV7', N'FS-4787/FS-14700', N'R2-11', N'Ready To Use', CAST(N'2024-07-19T15:51:26.0900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (462, N'Suzuki', N'YV7', N'FS-4674/FS-15100', N'R2-12', N'Ready To Use', CAST(N'2024-07-19T15:51:26.1300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (463, N'Suzuki', N'YV7', N'FS-4675/FS-15200', N'R2-13', N'Ready To Use', CAST(N'2024-07-19T15:51:26.1700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (464, N'Suzuki', N'YV7', N'FS-4434/FS-15300', N'R2-14', N'Ready To Use', CAST(N'2024-07-19T15:51:26.2000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (465, N'Suzuki', N'YV7', N'FS-5915/FS-15300', N'R2-15', N'Ready To Use', CAST(N'2024-07-19T15:51:26.2400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (466, N'Suzuki', N'YV7', N'FS-3729/FS-15300', N'R2-16', N'Ready To Use', CAST(N'2024-07-19T15:51:26.2800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (467, N'Suzuki', N'YV7', N'FS-11161/FS-15300', N'R2-17', N'Ready To Use', CAST(N'2024-07-19T15:51:26.3400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (468, N'Suzuki', N'YV7', N'6W-17851/FS-15300', N'R2-18', N'Ready To Use', CAST(N'2024-07-19T15:51:26.3800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (469, N'Suzuki', N'YV7', N'FS-6614/FS-15300', N'R2-19', N'Ready To Use', CAST(N'2024-07-19T15:51:26.4200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (470, N'Suzuki', N'YV7', N'FS-5489/FS-15400', N'R2-20', N'Ready To Use', CAST(N'2024-07-19T15:51:26.4600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (471, N'Suzuki', N'YV7', N'FS-4851/FS-15400', N'R2-21', N'Ready To Use', CAST(N'2024-07-19T15:51:26.5000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (472, N'Suzuki', N'YV7', N'FS-3287/FS-15400', N'R2-22', N'Ready To Use', CAST(N'2024-07-19T15:51:26.5400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (473, N'Suzuki', N'YV7', N'FS-3339/FS-15400', N'R2-23', N'Ready To Use', CAST(N'2024-07-19T15:51:26.5800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (474, N'Suzuki', N'YV7', N'FS-3323/FS-15400', N'R2-24', N'Ready To Use', CAST(N'2024-07-19T15:51:26.6300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (475, N'Suzuki', N'YV7', N'FS-4632/FS-15400', N'R2-25', N'Ready To Use', CAST(N'2024-07-19T15:51:26.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (476, N'Suzuki', N'YV7', N'FS-4192/FS-15400', N'R2-26', N'Ready To Use', CAST(N'2024-07-19T15:51:26.7100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (477, N'Suzuki', N'YV7', N'FS-9775/FS-15400', N'R2-27', N'Ready To Use', CAST(N'2024-07-19T15:51:26.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (478, N'Suzuki', N'YV7', N'FS-4852/FS-15400', N'R2-28', N'Ready To Use', CAST(N'2024-07-19T15:51:26.7800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (479, N'Suzuki', N'YV7', N'FS-3547/FS-15400', N'R2-29', N'Ready To Use', CAST(N'2024-07-19T15:51:26.8300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (480, N'Suzuki', N'YV7', N'FS-11361/FS-15400', N'R2-30', N'Ready To Use', CAST(N'2024-07-19T15:51:26.8700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (481, N'Suzuki', N'YV7', N'FS-4039/FS-15400', N'R2-31', N'Ready To Use', CAST(N'2024-07-19T15:51:26.9100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (482, N'Suzuki', N'YV7', N'FS-3111/FS-15400', N'R2-32', N'Ready To Use', CAST(N'2024-07-19T15:51:26.9500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (483, N'Suzuki', N'YV7', N'FS-4440/FS-15400', N'R2-33', N'Ready To Use', CAST(N'2024-07-19T15:51:26.9800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (484, N'Suzuki', N'YV7', N'FS-3258/FS-15400', N'R2-34', N'Ready To Use', CAST(N'2024-07-19T15:51:27.0200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (485, N'Suzuki', N'YV7', N'FS-9552/FS-15400', N'R2-35', N'Ready To Use', CAST(N'2024-07-19T15:51:27.0600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (486, N'Suzuki', N'YV7', N'FS-4445/FS-15500', N'R2-36', N'Ready To Use', CAST(N'2024-07-19T15:51:27.0900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (487, N'Suzuki', N'YV7', N'FS-3700/FS-17100', N'R2-37', N'Ready To Use', CAST(N'2024-07-19T15:51:27.1300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (488, N'Suzuki', N'YV7', N'6W-17349/FS-17100', N'R2-38', N'Ready To Use', CAST(N'2024-07-19T15:51:27.1700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (489, N'Suzuki', N'YV7', N'FS-5535/FS-17200', N'R2-39', N'Ready To Use', CAST(N'2024-07-19T15:51:27.2100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (490, N'Suzuki', N'YV7', N'FS-3701/FS-17200', N'R2-40', N'Ready To Use', CAST(N'2024-07-19T15:51:27.2600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (491, N'Suzuki', N'YV7', N'FS-3376/FS-17200', N'R3-1', N'Ready To Use', CAST(N'2024-07-19T15:51:27.3000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (492, N'Suzuki', N'YV7', N'FS-4443/FS-17200', N'R3-2', N'Ready To Use', CAST(N'2024-07-19T15:51:27.3400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (493, N'Suzuki', N'YV7', N'FS-10270/FS-17300', N'R3-3', N'Ready To Use', CAST(N'2024-07-19T15:51:27.3800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (494, N'Suzuki', N'YV7', N'FS-2901/FS-17300', N'R3-4', N'Ready To Use', CAST(N'2024-07-19T15:51:27.4200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (495, N'Suzuki', N'YV7', N'FS-0385/FS-17300', N'R3-5', N'Ready To Use', CAST(N'2024-07-19T15:51:27.4600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (496, N'Suzuki', N'YV7', N'FS-4854/FS-17300', N'R3-6', N'Ready To Use', CAST(N'2024-07-19T15:51:27.4900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (497, N'Suzuki', N'YV7', N'FS-4446/FS-17300', N'R3-7', N'Ready To Use', CAST(N'2024-07-19T15:51:27.5300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (498, N'Suzuki', N'YV7', N'FS-4895/FS-17300', N'R3-8', N'Ready To Use', CAST(N'2024-07-19T15:51:27.5700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (499, N'Suzuki', N'YV7', N'FS-3311/FS-17300', N'R3-9', N'Ready To Use', CAST(N'2024-07-19T15:51:27.6100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (500, N'Suzuki', N'YV7', N'FS-10785/FS-17300', N'R3-10', N'Ready To Use', CAST(N'2024-07-19T15:51:27.6500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (501, N'Suzuki', N'YV7', N'FS-2898/FS-17300', N'R3-11', N'Ready To Use', CAST(N'2024-07-19T15:51:27.6800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (502, N'Suzuki', N'YV7', N'FS-4612/FS-17300', N'R3-12', N'Ready To Use', CAST(N'2024-07-19T15:51:27.7200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (503, N'Suzuki', N'YV7', N'FS-3262/FS-17300', N'R3-13', N'Ready To Use', CAST(N'2024-07-19T15:51:27.7600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (504, N'Suzuki', N'YV7', N'FS-3550/FS-17300', N'R3-14', N'Ready To Use', CAST(N'2024-07-19T15:51:27.7900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (505, N'Suzuki', N'YV7', N'FS-4894/FS-17300', N'R3-15', N'Ready To Use', CAST(N'2024-07-19T15:51:27.8300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (506, N'Suzuki', N'YV7', N'FS-4855/FS-17300', N'R3-16', N'Ready To Use', CAST(N'2024-07-19T15:51:27.8700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (507, N'Suzuki', N'YV7', N'FS-10272/FS-17400', N'R3-17', N'Ready To Use', CAST(N'2024-07-19T15:51:27.9100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (508, N'Suzuki', N'YV7', N'6W-7775/FS-17400', N'R3-18', N'Ready To Use', CAST(N'2024-07-19T15:51:27.9400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (509, N'Suzuki', N'YV7', N'FS-4057/FS-19400', N'R3-19', N'Ready To Use', CAST(N'2024-07-19T15:51:27.9800000' AS DateTime2))
GO
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (510, N'Suzuki', N'YV7', N'6W-17549/FS-19500', N'R3-20', N'Ready To Use', CAST(N'2024-07-19T15:51:28.0200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (511, N'Suzuki', N'YV7', N'FS-4863/FS-200', N'R3-21', N'Ready To Use', CAST(N'2024-07-19T15:51:28.0600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (512, N'Suzuki', N'YV7', N'6W-8531-OM/FS-200', N'R3-22', N'Ready To Use', CAST(N'2024-07-19T15:51:28.1000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (513, N'Suzuki', N'YV7', N'FS-10558/FS-200', N'R3-23', N'Ready To Use', CAST(N'2024-07-19T15:51:28.1400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (514, N'Suzuki', N'YV7', N'FS-4670/FS-200', N'R3-24', N'Ready To Use', CAST(N'2024-07-19T15:51:28.1800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (515, N'Suzuki', N'YV7', N'FS-3379/FS-200', N'R3-25', N'Ready To Use', CAST(N'2024-07-19T15:51:28.2100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (516, N'Suzuki', N'YV7', N'FS-4393/FS-200', N'R3-26', N'Ready To Use', CAST(N'2024-07-19T15:51:28.2500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (517, N'Suzuki', N'YV7', N'FS-5461/FS-200', N'R3-27', N'Ready To Use', CAST(N'2024-07-19T15:51:28.2900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (518, N'Suzuki', N'YV7', N'6W-6776/FS-200', N'R3-28', N'Ready To Use', CAST(N'2024-07-19T15:51:28.3300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (519, N'Suzuki', N'YV7', N'FS-10188/FS-200', N'R4-1', N'Ready To Use', CAST(N'2024-07-19T15:51:28.3600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (520, N'Suzuki', N'YV7', N'FS-3453/FS-200', N'R4-2', N'Ready To Use', CAST(N'2024-07-19T15:51:28.4000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (521, N'Suzuki', N'YV7', N'FS-9129/FS-200', N'R4-3', N'Ready To Use', CAST(N'2024-07-19T15:51:28.4400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (522, N'Suzuki', N'YV7', N'6W-14229/FS-200', N'R4-4', N'Ready To Use', CAST(N'2024-07-19T15:51:28.4800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (523, N'Suzuki', N'YV7', N'FS-10576/FS-200', N'R4-5', N'Ready To Use', CAST(N'2024-07-19T15:51:28.5100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (524, N'Suzuki', N'YV7', N'FS-4455/FS-200', N'R4-6', N'Ready To Use', CAST(N'2024-07-19T15:51:28.5500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (525, N'Suzuki', N'YV7', N'FS-4153/FS-200', N'R4-7', N'Ready To Use', CAST(N'2024-07-19T15:51:28.5900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (526, N'Suzuki', N'YV7', N'FS-3690/FS-200', N'R4-8', N'Ready To Use', CAST(N'2024-07-19T15:51:28.6300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (527, N'Suzuki', N'YV7', N'FS-4690/FS-2200', N'R4-9', N'Ready To Use', CAST(N'2024-07-19T15:51:28.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (528, N'Suzuki', N'YV7', N'FS-5524/FS-2200', N'R4-10', N'Ready To Use', CAST(N'2024-07-19T15:51:28.7000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (529, N'Suzuki', N'YV7', N'FS-4919/FS-2200', N'R4-11', N'Ready To Use', CAST(N'2024-07-19T15:51:28.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (530, N'Suzuki', N'YV7', N'FS-3239/FS-2200', N'R4-12', N'Ready To Use', CAST(N'2024-07-19T15:51:28.7800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (531, N'Suzuki', N'YV7', N'FS-17060/FS-2200', N'R4-13', N'Ready To Use', CAST(N'2024-07-19T15:51:28.8100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (532, N'Suzuki', N'YV7', N'FS-4670/FS-2200', N'R4-14', N'Ready To Use', CAST(N'2024-07-19T15:51:28.8500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (533, N'Suzuki', N'YV7', N'6W-10791/FS-2200', N'R4-15', N'Ready To Use', CAST(N'2024-07-19T15:51:28.8900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (534, N'Suzuki', N'YV7', N'FS-4155/FS-2200', N'R4-16', N'Ready To Use', CAST(N'2024-07-19T15:51:28.9300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (535, N'Suzuki', N'YV7', N'FS-12560/FS-23000', N'R4-17', N'Ready To Use', CAST(N'2024-07-19T15:51:28.9600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (536, N'Suzuki', N'YV7', N'FS-4626/FS-23000', N'R4-18', N'Ready To Use', CAST(N'2024-07-19T15:51:29.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (537, N'Suzuki', N'YV7', N'FS-13010/FS-23100', N'R4-19', N'Ready To Use', CAST(N'2024-07-19T15:51:29.0400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (538, N'Suzuki', N'YV7', N'FS-4897/FS-23600', N'R4-20', N'Ready To Use', CAST(N'2024-07-19T15:51:29.0800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (539, N'Suzuki', N'YV7', N'FS-13024/FS-23600', N'R4-21', N'Ready To Use', CAST(N'2024-07-19T15:51:29.1300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (540, N'Suzuki', N'YV7', N'FS-17059/FS-23600', N'R4-22', N'Ready To Use', CAST(N'2024-07-19T15:51:29.1800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (541, N'Suzuki', N'YV7', N'FS-4898/FS-23700', N'R4-23', N'Ready To Use', CAST(N'2024-07-19T15:51:29.2200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (542, N'Suzuki', N'YV7', N'FS-4305/FS-2500', N'R4-24', N'Ready To Use', CAST(N'2024-07-19T15:51:29.2600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (543, N'Suzuki', N'YV7', N'FS-13006/FS-2500', N'R4-25', N'Ready To Use', CAST(N'2024-07-19T15:51:29.2900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (544, N'Suzuki', N'YV7', N'FS-4869/FS-2500', N'R4-26', N'Ready To Use', CAST(N'2024-07-19T15:51:29.3300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (545, N'Suzuki', N'YV7', N'FS-4617/FS-2500', N'R4-27', N'Ready To Use', CAST(N'2024-07-19T15:51:29.3700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (546, N'Suzuki', N'YV7', N'6W-16031/OS-20900', N'R4-28', N'Ready To Use', CAST(N'2024-07-19T15:51:29.4000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (547, N'Suzuki', N'YV7', N'FS-10081/FS-26900', N'R5-1', N'Ready To Use', CAST(N'2024-07-19T15:51:29.4500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (548, N'Suzuki', N'YV7', N'FS-10083/FS-2700', N'R5-2', N'Ready To Use', CAST(N'2024-07-19T15:51:29.4900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (549, N'Suzuki', N'YV7', N'FS-0966/FS-2800', N'R5-3', N'Ready To Use', CAST(N'2024-07-19T15:51:29.5200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (550, N'Suzuki', N'YV7', N'FS-5470/FS-2800', N'R5-4', N'Ready To Use', CAST(N'2024-07-19T15:51:29.5600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (551, N'Suzuki', N'YV7', N'FS-13004/FS-2800', N'R5-5', N'Ready To Use', CAST(N'2024-07-19T15:51:29.6000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (552, N'Suzuki', N'YV7', N'FS-5331/FS-2900', N'R5-6', N'Ready To Use', CAST(N'2024-07-19T15:51:29.6300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (553, N'Suzuki', N'YV7', N'FS-10166/FS-2900', N'R5-7', N'Ready To Use', CAST(N'2024-07-19T15:51:29.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (554, N'Suzuki', N'YV7', N'FS-5649/FS-2900', N'R5-8', N'Ready To Use', CAST(N'2024-07-19T15:51:29.7100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (555, N'Suzuki', N'YV7', N'FS-5506/FS-300', N'R5-9', N'Ready To Use', CAST(N'2024-07-19T15:51:29.7300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (556, N'Suzuki', N'YV7', N'FS-3851/FS-300', N'R5-10', N'Ready To Use', CAST(N'2024-07-19T15:51:29.7700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (557, N'Suzuki', N'YV7', N'FS-4637/FS-300', N'R5-11', N'Ready To Use', CAST(N'2024-07-19T15:51:29.8000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (558, N'Suzuki', N'YV7', N'6W-3327/FS-300', N'R5-12', N'Ready To Use', CAST(N'2024-07-19T15:51:29.8400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (559, N'Suzuki', N'YV7', N'FS-5655/FS-300', N'R5-13', N'Ready To Use', CAST(N'2024-07-19T15:51:29.8800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (560, N'Suzuki', N'YV7', N'FS-5652/FS-300', N'R5-14', N'Ready To Use', CAST(N'2024-07-19T15:51:29.9200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (561, N'Suzuki', N'YV7', N'FS-4195/FS-300', N'R5-15', N'Ready To Use', CAST(N'2024-07-19T15:51:29.9600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (562, N'Suzuki', N'YV7', N'FS-4416/FS-300', N'R5-16', N'Ready To Use', CAST(N'2024-07-19T15:51:29.9900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (563, N'Suzuki', N'YV7', N'FS-10237/FS-300', N'R5-17', N'Ready To Use', CAST(N'2024-07-19T15:51:30.0300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (564, N'Suzuki', N'YV7', N'FS-5654/FS-300', N'R5-18', N'Ready To Use', CAST(N'2024-07-19T15:51:30.0700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (565, N'Suzuki', N'YV7', N'FS-3382/FS-300', N'R5-19', N'Ready To Use', CAST(N'2024-07-19T15:51:30.1000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (566, N'Suzuki', N'YV7', N'6W-8543/FS-300', N'R5-20', N'Ready To Use', CAST(N'2024-07-19T15:51:30.1400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (567, N'Suzuki', N'YV7', N'FS-10480/FS-300', N'R5-21', N'Ready To Use', CAST(N'2024-07-19T15:51:30.1700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (568, N'Suzuki', N'YV7', N'FS-10233/FS-300', N'R5-22', N'Ready To Use', CAST(N'2024-07-19T15:51:30.2100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (569, N'Suzuki', N'YV7', N'FS-0858/FS-300', N'R5-23', N'Ready To Use', CAST(N'2024-07-19T15:51:30.2500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (570, N'Suzuki', N'YV7', N'FS-0860/FS-300', N'R5-24', N'Ready To Use', CAST(N'2024-07-19T15:51:30.2800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (571, N'Suzuki', N'YV7', N'FS-11172/FS-300', N'R5-25', N'Ready To Use', CAST(N'2024-07-19T15:51:30.3200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (572, N'Suzuki', N'YV7', N'6W-16202/FS-300', N'R5-26', N'Ready To Use', CAST(N'2024-07-19T15:51:30.3600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (573, N'Suzuki', N'YV7', N'FS-4635/FS-300', N'R5-27', N'Ready To Use', CAST(N'2024-07-19T15:51:30.3900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (574, N'Suzuki', N'YV7', N'FS-4639/FS-300', N'R5-28', N'Ready To Use', CAST(N'2024-07-19T15:51:30.4300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (575, N'Suzuki', N'YV7', N'FS-5674/FS-300', N'R6-1', N'Ready To Use', CAST(N'2024-07-19T15:51:30.4700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (576, N'Suzuki', N'YV7', N'FS-4191/FS-300', N'R6-2', N'Ready To Use', CAST(N'2024-07-19T15:51:30.5100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (577, N'Suzuki', N'YV7', N'FS-11173/FS-300', N'R6-3', N'Ready To Use', CAST(N'2024-07-19T15:51:30.5400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (578, N'Suzuki', N'YV7', N'FS-3454/FS-300', N'R6-4', N'Ready To Use', CAST(N'2024-07-19T15:51:30.5800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (579, N'Suzuki', N'YV7', N'FS-10287/FS-300', N'R6-5', N'Ready To Use', CAST(N'2024-07-19T15:51:30.6200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (580, N'Suzuki', N'YV7', N'FS-4661/FS-3100', N'R6-6', N'Ready To Use', CAST(N'2024-07-19T15:51:30.6500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (581, N'Suzuki', N'YV7', N'FS-4173/FS-31200', N'R6-7', N'Ready To Use', CAST(N'2024-07-19T15:51:30.6900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (582, N'Suzuki', N'YV7', N'FS-3498/FS-31200', N'R6-8', N'Ready To Use', CAST(N'2024-07-19T15:51:30.7300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (583, N'Suzuki', N'YV7', N'FS-5941/FS-31300', N'R6-9', N'Ready To Use', CAST(N'2024-07-19T15:51:30.7600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (584, N'Suzuki', N'YV7', N'FS-5572/FS-31400', N'R6-10', N'Ready To Use', CAST(N'2024-07-19T15:51:30.8000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (585, N'Suzuki', N'YV7', N'FS-4755/FS-31400', N'R6-11', N'Ready To Use', CAST(N'2024-07-19T15:51:30.8300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (586, N'Suzuki', N'YV7', N'FS-5859/FS-31500', N'R6-12', N'Ready To Use', CAST(N'2024-07-19T15:51:30.8700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (587, N'Suzuki', N'YV7', N'FS-3361/FS-31500', N'R6-13', N'Ready To Use', CAST(N'2024-07-19T15:51:30.9400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (588, N'Suzuki', N'YV7', N'FS-4252/FS-31500', N'R6-14', N'Ready To Use', CAST(N'2024-07-19T15:51:30.9800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (589, N'Suzuki', N'YV7', N'6W-12729/FS-31500', N'R6-15', N'Ready To Use', CAST(N'2024-07-19T15:51:31.0100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (590, N'Suzuki', N'YV7', N'FS-9146/FS-31500', N'R6-16', N'Ready To Use', CAST(N'2024-07-19T15:51:31.0500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (591, N'Suzuki', N'YV7', N'6W-12953/FS-31500', N'R6-17', N'Ready To Use', CAST(N'2024-07-19T15:51:31.0900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (592, N'Suzuki', N'YV7', N'FS-5355/FS-31500', N'R6-18', N'Ready To Use', CAST(N'2024-07-19T15:51:31.1400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (593, N'Suzuki', N'YV7', N'6W-9409/FS-31600', N'R6-19', N'Ready To Use', CAST(N'2024-07-19T15:51:31.1800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (594, N'Suzuki', N'YV7', N'FS-6169/FS-31900', N'R6-20', N'Ready To Use', CAST(N'2024-07-19T15:51:31.2200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (595, N'Suzuki', N'YV7', N'FS-0082/FS-31900', N'R6-21', N'Ready To Use', CAST(N'2024-07-19T15:51:31.2500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (596, N'Suzuki', N'YV7', N'FS-11362/FS-3200', N'R6-22', N'Ready To Use', CAST(N'2024-07-19T15:51:31.2900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (597, N'Suzuki', N'YV7', N'FS-4059/FS-32200', N'R6-23', N'Ready To Use', CAST(N'2024-07-19T15:51:31.3300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (598, N'Suzuki', N'YV7', N'FS-1008/FS-32200', N'R6-24', N'Ready To Use', CAST(N'2024-07-19T15:51:31.3600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (599, N'Suzuki', N'YV7', N'FS-4679/FS-33900', N'R6-25', N'Ready To Use', CAST(N'2024-07-19T15:51:31.4000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (600, N'Suzuki', N'YV7', N'FS-1005/FS-34100', N'R6-26', N'Ready To Use', CAST(N'2024-07-19T15:51:31.4400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (601, N'Suzuki', N'YV7', N'FS-4681/FS-34800', N'R6-27', N'Ready To Use', CAST(N'2024-07-19T15:51:31.4700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (602, N'Suzuki', N'YV7', N'FS-1104/FS-36300', N'R6-28', N'Ready To Use', CAST(N'2024-07-19T15:51:31.5100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (603, N'Suzuki', N'YV7', N'FS-4665/FS-3700', N'R7-1', N'Ready To Use', CAST(N'2024-07-19T15:51:31.5500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (604, N'Suzuki', N'YV7', N'6W-7998/FS-3700', N'R7-2', N'Ready To Use', CAST(N'2024-07-19T15:51:31.5800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (605, N'Suzuki', N'YV7', N'FS-4871/FS-3700', N'R7-3', N'Ready To Use', CAST(N'2024-07-19T15:51:31.6200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (606, N'Suzuki', N'YV7', N'6W-18431/FS-37400', N'R7-4', N'Ready To Use', CAST(N'2024-07-19T15:51:31.6600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (607, N'Suzuki', N'YV7', N'FS-9892/FS-3800', N'R7-5', N'Ready To Use', CAST(N'2024-07-19T15:51:31.6900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (608, N'Suzuki', N'YV7', N'FS-4065/FS-3800', N'R7-6', N'Ready To Use', CAST(N'2024-07-19T15:51:31.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (609, N'Suzuki', N'YV7', N'FS-10208/FS-3800', N'R7-7', N'Ready To Use', CAST(N'2024-07-19T15:51:31.7800000' AS DateTime2))
GO
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (610, N'Suzuki', N'YV7', N'FS-0826/FS-3800', N'R7-8', N'Ready To Use', CAST(N'2024-07-19T15:51:31.8200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (611, N'Suzuki', N'YV7', N'FS-5464/FS-400', N'R7-9', N'Ready To Use', CAST(N'2024-07-19T15:51:31.8600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (612, N'Suzuki', N'YV7', N'FS-2888/FS-400', N'R7-10', N'Ready To Use', CAST(N'2024-07-19T15:51:31.8900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (613, N'Suzuki', N'YV7', N'FS-2887/FS-400', N'R7-11', N'Ready To Use', CAST(N'2024-07-19T15:51:31.9300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (614, N'Suzuki', N'YV7', N'FS-10228/FS-400', N'R7-12', N'Ready To Use', CAST(N'2024-07-19T15:51:31.9700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (615, N'Suzuki', N'YV7', N'FS-4656/FS-400', N'R7-13', N'Ready To Use', CAST(N'2024-07-19T15:51:32.0100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (616, N'Suzuki', N'YV7', N'FS-9148/FS-400', N'R7-14', N'Ready To Use', CAST(N'2024-07-19T15:51:32.0400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (617, N'Suzuki', N'YV7', N'FS-10245/FS-4100', N'R7-15', N'Ready To Use', CAST(N'2024-07-19T15:51:32.0800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (618, N'Suzuki', N'YV7', N'FS-3958/FS-4100', N'R7-16', N'Ready To Use', CAST(N'2024-07-19T15:51:32.1200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (619, N'Suzuki', N'YV7', N'FS-4876/FS-4100', N'R7-17', N'Ready To Use', CAST(N'2024-07-19T15:51:32.1500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (620, N'Suzuki', N'YV7', N'FS-4875/FS-4100', N'R7-18', N'Ready To Use', CAST(N'2024-07-19T15:51:32.1900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (621, N'Suzuki', N'YV7', N'FS-11821/FS-4100', N'R7-19', N'Ready To Use', CAST(N'2024-07-19T15:51:32.2300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (622, N'Suzuki', N'YV7', N'FS-10249/FS-4100', N'R7-20', N'Ready To Use', CAST(N'2024-07-19T15:51:32.2700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (623, N'Suzuki', N'YV7', N'FS-4874/FS-4100', N'R7-21', N'Ready To Use', CAST(N'2024-07-19T15:51:32.3000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (624, N'Suzuki', N'YV7', N'FS-2884/FS-4100', N'R7-22', N'Ready To Use', CAST(N'2024-07-19T15:51:32.3400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (625, N'Suzuki', N'YV7', N'FS-5663/FS-4100', N'R7-23', N'Ready To Use', CAST(N'2024-07-19T15:51:32.3700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (626, N'Suzuki', N'YV7', N'FS-5517/FS-4100', N'R7-24', N'Ready To Use', CAST(N'2024-07-19T15:51:32.4100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (627, N'Suzuki', N'YV7', N'FS-11820/FS-4100', N'R7-25', N'Ready To Use', CAST(N'2024-07-19T15:51:32.4500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (628, N'Suzuki', N'YV7', N'6W-12217/FS-4100', N'R7-26', N'Ready To Use', CAST(N'2024-07-19T15:51:32.4900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (629, N'Suzuki', N'YV7', N'FS-10247/FS-4100', N'R7-27', N'Ready To Use', CAST(N'2024-07-19T15:51:32.5200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (630, N'Suzuki', N'YV7', N'FS-0959/FS-4100', N'R7-28', N'Ready To Use', CAST(N'2024-07-19T15:51:32.5600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (631, N'Suzuki', N'YV7', N'FS-4151/FS-4100', N'R8-1', N'Ready To Use', CAST(N'2024-07-19T15:51:32.6000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (632, N'Suzuki', N'YV7', N'FS-8967/FS-4100', N'R8-2', N'Ready To Use', CAST(N'2024-07-19T15:51:32.6300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (633, N'Suzuki', N'YV7', N'FS-10172/FS-4200', N'R8-3', N'Ready To Use', CAST(N'2024-07-19T15:51:32.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (634, N'Suzuki', N'YV7', N'FS-0800/FS-4200', N'R8-4', N'Ready To Use', CAST(N'2024-07-19T15:51:32.7100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (635, N'Suzuki', N'YV7', N'FS-3460/FS-4200', N'R8-5', N'Ready To Use', CAST(N'2024-07-19T15:51:32.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (636, N'Suzuki', N'YV7', N'FS-5665/FS-4200', N'R8-6', N'Ready To Use', CAST(N'2024-07-19T15:51:32.7800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (637, N'Suzuki', N'YV7', N'FS-3352/FS-4200', N'R8-7', N'Ready To Use', CAST(N'2024-07-19T15:51:32.8200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (638, N'Suzuki', N'YV7', N'FS-10171/FS-4200', N'R8-8', N'Ready To Use', CAST(N'2024-07-19T15:51:32.8500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (639, N'Suzuki', N'YV7', N'6W-18742/FS-42400', N'R8-9', N'Ready To Use', CAST(N'2024-07-19T15:51:32.8900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (640, N'Suzuki', N'YV7', N'6W-5024/FS-44000', N'R8-10', N'Ready To Use', CAST(N'2024-07-19T15:51:32.9400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (641, N'Suzuki', N'YV7', N'6W-13880/FS-44000', N'R8-11', N'Ready To Use', CAST(N'2024-07-19T15:51:32.9800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (642, N'Suzuki', N'YV7', N'FS-5581/FS-44400', N'R8-12', N'Ready To Use', CAST(N'2024-07-19T15:51:33.0100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (643, N'Suzuki', N'YV7', N'FS-4973/FS-4600', N'R8-13', N'Ready To Use', CAST(N'2024-07-19T15:51:33.0500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (644, N'Suzuki', N'YV7', N'FS-4777/FS-4600', N'R8-14', N'Ready To Use', CAST(N'2024-07-19T15:51:33.0900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (645, N'Suzuki', N'YV7', N'FS-0965/FS-4700', N'R8-15', N'Ready To Use', CAST(N'2024-07-19T15:51:33.1200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (646, N'Suzuki', N'YV7', N'FS-4625/FS-4700', N'R8-16', N'Ready To Use', CAST(N'2024-07-19T15:51:33.1600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (647, N'Suzuki', N'YV7', N'FS-11368/FS-49100', N'R8-17', N'Ready To Use', CAST(N'2024-07-19T15:51:33.2000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (648, N'Suzuki', N'YV7', N'FS-4892/FS-500', N'R8-18', N'Ready To Use', CAST(N'2024-07-19T15:51:33.2300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (649, N'Suzuki', N'YV7', N'FS-10174/FS-5100', N'R8-19', N'Ready To Use', CAST(N'2024-07-19T15:51:33.2700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (650, N'Suzuki', N'YV7', N'FS-4903/FS-5300', N'R8-20', N'Ready To Use', CAST(N'2024-07-19T15:51:33.3100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (651, N'Suzuki', N'YV7', N'FS-3245/FS-5500', N'R8-21', N'Ready To Use', CAST(N'2024-07-19T15:51:33.3400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (652, N'Suzuki', N'YV7', N'FS-3461/FS-5500', N'R8-22', N'Ready To Use', CAST(N'2024-07-19T15:51:33.3800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (653, N'Suzuki', N'YV7', N'FS-3356/FS-5500', N'R8-23', N'Ready To Use', CAST(N'2024-07-19T15:51:33.4200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (654, N'Suzuki', N'YV7', N'FS-10788/FS-5500', N'R8-24', N'Ready To Use', CAST(N'2024-07-19T15:51:33.4500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (655, N'Suzuki', N'YV7', N'FS-3464/FS-5600', N'R8-25', N'Ready To Use', CAST(N'2024-07-19T15:51:33.5600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (656, N'Suzuki', N'YV7', N'FS-5027/FS-5600', N'R8-26', N'Ready To Use', CAST(N'2024-07-19T15:51:33.6000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (657, N'Suzuki', N'YV7', N'FS-0868/FS-5600', N'R8-27', N'Ready To Use', CAST(N'2024-07-19T15:51:33.6300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (658, N'Suzuki', N'YV7', N'6W-10415-OM/FS-5600', N'R8-28', N'Ready To Use', CAST(N'2024-07-19T15:51:33.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (659, N'Suzuki', N'YV7', N'FS-0131/FS-5600', N'R9-1', N'Ready To Use', CAST(N'2024-07-19T15:51:33.7100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (660, N'Suzuki', N'YV7', N'FS-7706/FS-5600', N'R9-2', N'Ready To Use', CAST(N'2024-07-19T15:51:33.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (661, N'Suzuki', N'YV7', N'FS-12985/FS-56400', N'R9-3', N'Ready To Use', CAST(N'2024-07-19T15:51:33.7800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (662, N'Suzuki', N'YV7', N'FS-10207/FS-56400', N'R9-4', N'Ready To Use', CAST(N'2024-07-19T15:51:33.8200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (663, N'Suzuki', N'YV7', N'FS-10582/FS-56900', N'R9-5', N'Ready To Use', CAST(N'2024-07-19T15:51:33.8600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (664, N'Suzuki', N'YV7', N'FS-12991/FS-56900', N'R9-6', N'Ready To Use', CAST(N'2024-07-19T15:51:33.8900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (665, N'Suzuki', N'YV7', N'FS-10241/FS-5800', N'R9-7', N'Ready To Use', CAST(N'2024-07-19T15:51:33.9300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (666, N'Suzuki', N'YV7', N'FS-4348/FS-5800', N'R9-8', N'Ready To Use', CAST(N'2024-07-19T15:51:33.9700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (667, N'Suzuki', N'YV7', N'FS-3249/FS-5800', N'R9-9', N'Ready To Use', CAST(N'2024-07-19T15:51:34.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (668, N'Suzuki', N'YV7', N'FS-2813/FS-5800', N'R9-10', N'Ready To Use', CAST(N'2024-07-19T15:51:34.0400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (669, N'Suzuki', N'YV7', N'FS-3335/FS-5900', N'R9-11', N'Ready To Use', CAST(N'2024-07-19T15:51:34.0800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (670, N'Suzuki', N'YV7', N'FS-2896/FS-5900', N'R9-12', N'Ready To Use', CAST(N'2024-07-19T15:51:34.1200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (671, N'Suzuki', N'YV7', N'FS-7653/FS-600', N'R9-13', N'Ready To Use', CAST(N'2024-07-19T15:51:34.1500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (672, N'Suzuki', N'YV7', N'FS-5631/FS-6000', N'R9-14', N'Ready To Use', CAST(N'2024-07-19T15:51:34.1900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (673, N'Suzuki', N'YV7', N'FS-4460/FS-6000', N'R9-15', N'Ready To Use', CAST(N'2024-07-19T15:51:34.2200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (674, N'Suzuki', N'YV7', N'6W-17346/FS-6000', N'R9-16', N'Ready To Use', CAST(N'2024-07-19T15:51:34.2600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (675, N'Suzuki', N'YV7', N'FS-17057/FS-6200', N'R9-17', N'Ready To Use', CAST(N'2024-07-19T15:51:34.3000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (676, N'Suzuki', N'YV7', N'FS-3252/FS-6200', N'R9-18', N'Ready To Use', CAST(N'2024-07-19T15:51:34.3700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (677, N'Suzuki', N'YV7', N'FS-5481/FS-6200', N'R9-19', N'Ready To Use', CAST(N'2024-07-19T15:51:34.4300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (678, N'Suzuki', N'YV7', N'FS-3357/FS-6200', N'R9-20', N'Ready To Use', CAST(N'2024-07-19T15:51:34.4600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (679, N'Suzuki', N'YV7', N'FS-3706/FS-6200', N'R9-21', N'Ready To Use', CAST(N'2024-07-19T15:51:34.5000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (680, N'Suzuki', N'YV7', N'FS-3358/FS-6200', N'R9-22', N'Ready To Use', CAST(N'2024-07-19T15:51:34.5400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (681, N'Suzuki', N'YV7', N'FS-2780/FS-6200', N'R9-23', N'Ready To Use', CAST(N'2024-07-19T15:51:34.5700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (682, N'Suzuki', N'YV7', N'FS-5526/FS-6300', N'R9-24', N'Ready To Use', CAST(N'2024-07-19T15:51:34.6100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (683, N'Suzuki', N'YV7', N'FS-5668/FS-6300', N'R9-25', N'Ready To Use', CAST(N'2024-07-19T15:51:34.6500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (684, N'Suzuki', N'YV7', N'FS-3255/FS-6400', N'R9-26', N'Ready To Use', CAST(N'2024-07-19T15:51:34.6800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (685, N'Suzuki', N'YV7', N'FS-9847/FS-6400', N'R9-27', N'Ready To Use', CAST(N'2024-07-19T15:51:34.7200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (686, N'Suzuki', N'YV7', N'FS-3720/FS-6400', N'R9-28', N'Ready To Use', CAST(N'2024-07-19T15:51:34.7600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (687, N'Suzuki', N'YV7', N'FS-12983/FS-6400', N'R10-1', N'Ready To Use', CAST(N'2024-07-19T15:51:34.7900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (688, N'Suzuki', N'YV7', N'FS-3630/FS-6400', N'R10-2', N'Ready To Use', CAST(N'2024-07-19T15:51:34.8300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (689, N'Suzuki', N'YV7', N'FS-12984/FS-6400', N'R10-3', N'Ready To Use', CAST(N'2024-07-19T15:51:34.8700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (690, N'Suzuki', N'YV7', N'FS-9891/FS-6400', N'R10-4', N'Ready To Use', CAST(N'2024-07-19T15:51:34.9000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (691, N'Suzuki', N'YV7', N'FS-3097/FS-6400', N'R10-5', N'Ready To Use', CAST(N'2024-07-19T15:51:34.9400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (692, N'Suzuki', N'YV7', N'FS-10204/FS-6400', N'R10-6', N'Ready To Use', CAST(N'2024-07-19T15:51:34.9800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (693, N'Suzuki', N'YV7', N'FS-10577/FS-6400', N'R10-7', N'Ready To Use', CAST(N'2024-07-19T15:51:35.0400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (694, N'Suzuki', N'YV7', N'FS-11195/FS-6400', N'R10-8', N'Ready To Use', CAST(N'2024-07-19T15:51:35.0800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (695, N'Suzuki', N'YV7', N'FS-10573/FS-6400', N'R10-9', N'Ready To Use', CAST(N'2024-07-19T15:51:35.1100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (696, N'Suzuki', N'YV7', N'FS-4731/FS-6400', N'R10-10', N'Ready To Use', CAST(N'2024-07-19T15:51:35.1500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (697, N'Suzuki', N'YV7', N'FS-3721/FS-6400', N'R10-11', N'Ready To Use', CAST(N'2024-07-19T15:51:35.1900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (698, N'Suzuki', N'YV7', N'FS-3343/FS-6500', N'R10-12', N'Ready To Use', CAST(N'2024-07-19T15:51:35.2200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (699, N'Suzuki', N'YV7', N'FS-4966/FS-6500', N'R10-13', N'Ready To Use', CAST(N'2024-07-19T15:51:35.2600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (700, N'Suzuki', N'YV7', N'FS-3564/FS-6500', N'R10-14', N'Ready To Use', CAST(N'2024-07-19T15:51:35.3000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (701, N'Suzuki', N'YV7', N'FS-10082/FS-65200', N'R10-15', N'Ready To Use', CAST(N'2024-07-19T15:51:35.3400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (702, N'Suzuki', N'YV7', N'FS-10306/FS-65200', N'R10-16', N'Ready To Use', CAST(N'2024-07-19T15:51:35.3700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (703, N'Suzuki', N'YV7', N'FS-1257/FS-6600', N'R10-17', N'Ready To Use', CAST(N'2024-07-19T15:51:35.4100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (704, N'Suzuki', N'YV7', N'FS-4907/FS-6600', N'R10-18', N'Ready To Use', CAST(N'2024-07-19T15:51:35.4500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (705, N'Suzuki', N'YV7', N'FS-4182/FS-6600', N'R10-19', N'Ready To Use', CAST(N'2024-07-19T15:51:35.4800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (706, N'Suzuki', N'YV7', N'FS-14061/FS-66200', N'R10-20', N'Ready To Use', CAST(N'2024-07-19T15:51:35.5200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (707, N'Suzuki', N'YV7', N'6W-17881/OS-41000', N'R10-21', N'Ready To Use', CAST(N'2024-07-19T15:51:35.5600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (708, N'Suzuki', N'YV7', N'6W-17847/OS-41000', N'R10-22', N'Ready To Use', CAST(N'2024-07-19T15:51:35.5900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (709, N'Suzuki', N'YV7', N'FS-4172/FS-6800', N'R10-23', N'Ready To Use', CAST(N'2024-07-19T15:51:35.6300000' AS DateTime2))
GO
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (710, N'Suzuki', N'YV7', N'FS-13014/FS-6800', N'R10-24', N'Ready To Use', CAST(N'2024-07-19T15:51:35.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (711, N'Suzuki', N'YV7', N'FS-13013/FS-6800', N'R10-25', N'Ready To Use', CAST(N'2024-07-19T15:51:35.7000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (712, N'Suzuki', N'YV7', N'FS-4171/FS-6900', N'R10-26', N'Ready To Use', CAST(N'2024-07-19T15:51:35.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (713, N'Suzuki', N'YV7', N'FS-4781/FS-6900', N'R10-27', N'Ready To Use', CAST(N'2024-07-19T15:51:35.7700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (714, N'Suzuki', N'YV7', N'FS-5260/FS-7000', N'R10-28', N'Ready To Use', CAST(N'2024-07-19T15:51:35.8100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (715, N'Suzuki', N'YV7', N'FS-4734/FS-7100', N'R11-1', N'Ready To Use', CAST(N'2024-07-19T15:51:35.8500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (716, N'Suzuki', N'YV7', N'6W-17812/FS-7100', N'R11-2', N'Ready To Use', CAST(N'2024-07-19T15:51:35.8800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (717, N'Suzuki', N'YV7', N'FS-11189/FS-72400', N'R11-3', N'Ready To Use', CAST(N'2024-07-19T15:51:35.9200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (718, N'Suzuki', N'YV7', N'FS-12994/FS-72500', N'R11-4', N'Ready To Use', CAST(N'2024-07-19T15:51:35.9600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (719, N'Suzuki', N'YV7', N'FS-13017/FS-74300', N'R11-5', N'Ready To Use', CAST(N'2024-07-19T15:51:35.9900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (720, N'Suzuki', N'YV7', N'FS-13002/FS-74700', N'R11-6', N'Ready To Use', CAST(N'2024-07-19T15:51:36.0300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (721, N'Suzuki', N'YV7', N'FS-13011/FS-74900', N'R11-7', N'Ready To Use', CAST(N'2024-07-19T15:51:36.0700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (722, N'Suzuki', N'YV7', N'FS-13021/FS-76300', N'R11-8', N'Ready To Use', CAST(N'2024-07-19T15:51:36.1100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (723, N'Suzuki', N'YV7', N'FS-13022/FS-76300', N'R11-9', N'Ready To Use', CAST(N'2024-07-19T15:51:36.1400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (724, N'Suzuki', N'YV7', N'FS-13019/FS-76300', N'R11-10', N'Ready To Use', CAST(N'2024-07-19T15:51:36.1800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (725, N'Suzuki', N'YV7', N'FS-10086/FS-76300', N'R11-11', N'Ready To Use', CAST(N'2024-07-19T15:51:36.2200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (726, N'Suzuki', N'YV7', N'FS-3957/FS-77000', N'R11-12', N'Ready To Use', CAST(N'2024-07-19T15:51:36.2500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (727, N'Suzuki', N'YV7', N'FS-10583/FS-77000', N'R11-13', N'Ready To Use', CAST(N'2024-07-19T15:51:36.2900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (728, N'Suzuki', N'YV7', N'FS-10125/FS-77700', N'R11-14', N'Ready To Use', CAST(N'2024-07-19T15:51:36.3300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (729, N'Suzuki', N'YV7', N'FS-12978/FS-77800', N'R11-15', N'Ready To Use', CAST(N'2024-07-19T15:51:36.3600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (730, N'Suzuki', N'YV7', N'FS-10085/FS-79900', N'R11-16', N'Ready To Use', CAST(N'2024-07-19T15:51:36.4000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (731, N'Suzuki', N'YV7', N'FS-4867/FS-800', N'R11-17', N'Ready To Use', CAST(N'2024-07-19T15:51:36.4400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (732, N'Suzuki', N'YV7', N'FS-3704/FS-800', N'R11-18', N'Ready To Use', CAST(N'2024-07-19T15:51:36.5200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (733, N'Suzuki', N'YV7', N'FS-5689/FS-800', N'R11-19', N'Ready To Use', CAST(N'2024-07-19T15:51:36.5600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (734, N'Suzuki', N'YV7', N'FS-4839/FS-800', N'R11-20', N'Ready To Use', CAST(N'2024-07-19T15:51:36.5900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (735, N'Suzuki', N'YV7', N'FS-4765/FS-8100', N'R11-21', N'Ready To Use', CAST(N'2024-07-19T15:51:36.6300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (736, N'Suzuki', N'YV7', N'FS-3395/FS-8100', N'R11-22', N'Ready To Use', CAST(N'2024-07-19T15:51:36.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (737, N'Suzuki', N'YV7', N'FS-10585/FS-81500', N'R11-23', N'Ready To Use', CAST(N'2024-07-19T15:51:36.7000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (738, N'Suzuki', N'YV7', N'FS-4320/FS-900', N'R11-24', N'Ready To Use', CAST(N'2024-07-19T15:51:36.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (739, N'Suzuki', N'YV7', N'6W-7733-0M/FS-92500', N'R11-25', N'Ready To Use', CAST(N'2024-07-19T15:51:36.7900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (740, N'Suzuki', N'YV7', N'FS-3946/FS-9600', N'R11-26', N'Ready To Use', CAST(N'2024-07-19T15:51:36.8300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (741, N'Suzuki', N'YV7', N'FS-10278/FS-9600', N'R11-27', N'Ready To Use', CAST(N'2024-07-19T15:51:36.8700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (742, N'Suzuki', N'YV7', N'FS-12076/FS-9800', N'R11-28', N'Ready To Use', CAST(N'2024-07-19T15:51:36.9000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (743, N'Suzuki', N'YV7', N'FS-13030/FS-9800', N'R12-1', N'Ready To Use', CAST(N'2024-07-19T15:51:36.9400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (744, N'Suzuki', N'YV7', N'FS-13029/FS-9800', N'R12-2', N'Ready To Use', CAST(N'2024-07-19T15:51:36.9800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (745, N'Suzuki', N'YV7', N'FS-13032/FS-9800', N'R12-3', N'Ready To Use', CAST(N'2024-07-19T15:51:37.0100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (746, N'Suzuki', N'YV7', N'FS-4725/FS-9800', N'R12-4', N'Ready To Use', CAST(N'2024-07-19T15:51:37.0500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (747, N'Suzuki', N'YV7', N'FS-5033/FS-9800', N'R12-5', N'Ready To Use', CAST(N'2024-07-19T15:51:37.0900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (748, N'Suzuki', N'YV7', N'FS-12077/FS-9800', N'R12-6', N'Ready To Use', CAST(N'2024-07-19T15:51:37.1200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (749, N'Suzuki', N'YV7', N'FS-5030/FS-9800', N'R12-7', N'Ready To Use', CAST(N'2024-07-19T15:51:37.1600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (750, N'Suzuki', N'YV7', N'FS-13033/FS-9800', N'R12-8', N'Ready To Use', CAST(N'2024-07-19T15:51:37.2000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (751, N'Suzuki', N'YV7', N'FS-13028/FS-9800', N'R12-9', N'Ready To Use', CAST(N'2024-07-19T15:51:37.2300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (752, N'Suzuki', N'YV7', N'FS-5032/FS-9800', N'R12-10', N'Ready To Use', CAST(N'2024-07-19T15:51:37.2700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (753, N'Suzuki', N'YV7', N'FS-3853/FS-9900', N'R12-11', N'Ready To Use', CAST(N'2024-07-19T15:51:37.3000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (754, N'Suzuki', N'YV7', N'FS-3243/FS-9900', N'R12-12', N'Ready To Use', CAST(N'2024-07-19T15:51:37.3400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (755, N'Suzuki', N'YV7', N'6W-16929/OE-10000', N'R12-13', N'Ready To Use', CAST(N'2024-07-19T15:51:37.3800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (756, N'Suzuki', N'YV7', N'6W-17867/OE-1900', N'R12-14', N'Ready To Use', CAST(N'2024-07-19T15:51:37.4100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (757, N'Suzuki', N'YV7', N'6W-7326/OE-20100', N'R12-15', N'Ready To Use', CAST(N'2024-07-19T15:51:37.4500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (758, N'Suzuki', N'YV7', N'6W-17739/OE-20200', N'R12-16', N'Ready To Use', CAST(N'2024-07-19T15:51:37.4900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (759, N'Suzuki', N'YV7', N'6W-17592/OE-2200', N'R12-17', N'Ready To Use', CAST(N'2024-07-19T15:51:37.5200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (760, N'Suzuki', N'YV7', N'6W-17743/OE-23500', N'R12-18', N'Ready To Use', CAST(N'2024-07-19T15:51:37.5600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (761, N'Suzuki', N'YV7', N'6W-18156/OE-25900', N'R12-19', N'Ready To Use', CAST(N'2024-07-19T15:51:37.6000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (762, N'Suzuki', N'YV7', N'6W-19298/OE-25900', N'R12-20', N'Ready To Use', CAST(N'2024-07-19T15:51:37.6300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (763, N'Suzuki', N'YV7', N'6W-19727/OE-25900', N'R12-21', N'Ready To Use', CAST(N'2024-07-19T15:51:37.6700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (764, N'Suzuki', N'YV7', N'6W-19299/OE-25900', N'R12-22', N'Ready To Use', CAST(N'2024-07-19T15:51:37.7100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (765, N'Suzuki', N'YV7', N'6W-17742/OE-26500', N'R12-23', N'Ready To Use', CAST(N'2024-07-19T15:51:37.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (766, N'Suzuki', N'YV7', N'6W-19191/OE-27200', N'R12-24', N'Ready To Use', CAST(N'2024-07-19T15:51:37.7800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (767, N'Suzuki', N'YV7', N'6W-19729/OE-30700', N'R12-25', N'Ready To Use', CAST(N'2024-07-19T15:51:37.8100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (768, N'Suzuki', N'YV7', N'6W-17383/OE-30700', N'R12-26', N'Ready To Use', CAST(N'2024-07-19T15:51:37.8500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (769, N'Suzuki', N'YV7', N'6W-17759/OE-30700', N'R12-27', N'Ready To Use', CAST(N'2024-07-19T15:51:37.8900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (770, N'Suzuki', N'YV7', N'6W-19730/OE-30800', N'R12-28', N'Ready To Use', CAST(N'2024-07-19T15:51:37.9200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (771, N'Suzuki', N'YV7', N'6W-17065/OE-30800', N'R13-1', N'Ready To Use', CAST(N'2024-07-19T15:51:37.9600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (772, N'Suzuki', N'YV7', N'/OE-31400', N'R13-2', N'Ready To Use', CAST(N'2024-07-19T15:51:38.0000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (773, N'Suzuki', N'YV7', N'6W-17788/OE-4900', N'R13-3', N'Ready To Use', CAST(N'2024-07-19T15:51:38.0400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (774, N'Suzuki', N'YV7', N'/OE-4900', N'R13-4', N'Ready To Use', CAST(N'2024-07-19T15:51:38.0700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (775, N'Suzuki', N'YV7', N'6W-17226/OE-7300', N'R13-5', N'Ready To Use', CAST(N'2024-07-19T15:51:38.1100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (776, N'Suzuki', N'YV7', N'6W-19272/OE-7800', N'R13-6', N'Ready To Use', CAST(N'2024-07-19T15:51:38.1500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (777, N'Suzuki', N'YV7', N'6W-17224/OE-8400', N'R13-7', N'Ready To Use', CAST(N'2024-07-19T15:51:38.1800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (778, N'Suzuki', N'YV7', N'6W-17735/OS-15000', N'R13-8', N'Ready To Use', CAST(N'2024-07-19T15:51:38.2200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (779, N'Suzuki', N'YV7', N'6W-17848/OS-19500', N'R13-9', N'Ready To Use', CAST(N'2024-07-19T15:51:38.2600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (780, N'Suzuki', N'YV7', N'6W-10803-OM/OS-22000', N'R13-10', N'Ready To Use', CAST(N'2024-07-19T15:51:38.2900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (781, N'Suzuki', N'YV7', N'6W-17841/OS-24800', N'R13-11', N'Ready To Use', CAST(N'2024-07-19T15:51:38.3300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (782, N'Suzuki', N'YV7', N'6W-9396/OS-28600', N'R13-12', N'Ready To Use', CAST(N'2024-07-19T15:51:38.3700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (783, N'Suzuki', N'YV7', N'FS-3725/OS-37700', N'R13-13', N'Ready To Use', CAST(N'2024-07-19T15:51:38.4100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (784, N'Suzuki', N'YV7', N'6W-12264/OS-4200', N'R13-14', N'Ready To Use', CAST(N'2024-07-19T15:51:38.4400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (785, N'Suzuki', N'YV7', N'6W-2434/OS-4300', N'R13-15', N'Ready To Use', CAST(N'2024-07-19T15:51:38.4800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (786, N'Suzuki', N'YV7', N'6W-16989/OS-44700', N'R13-16', N'Ready To Use', CAST(N'2024-07-19T15:51:38.5200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (787, N'Suzuki', N'YV7', N'6W-19279/OS-44700', N'R13-17', N'Ready To Use', CAST(N'2024-07-19T15:51:38.5500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (789, N'Suzuki', N'YV7', N'6W-17751/OS-50200', N'R13-19', N'Ready To Use', CAST(N'2024-07-19T15:51:44.6200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (790, N'Suzuki', N'YV7', N'6W-17750/OS-50300', N'R13-20', N'Ready To Use', CAST(N'2024-07-19T15:51:44.6900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (791, N'Suzuki', N'YV7', N'6W-17807/OS-53400', N'R13-21', N'Ready To Use', CAST(N'2024-07-19T15:51:44.7500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (792, N'Suzuki', N'YV7', N'6W-16986/OS-55700', N'R13-22', N'Ready To Use', CAST(N'2024-07-19T15:51:44.7900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (793, N'Suzuki', N'YV7', N'6W-18392/OS-58700', N'R13-23', N'Ready To Use', CAST(N'2024-07-19T15:51:44.8300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (794, N'Suzuki', N'YV7', N'6W-17298/OS-58700', N'R13-24', N'Ready To Use', CAST(N'2024-07-19T15:51:44.8700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (795, N'Suzuki', N'YV7', N'6W-17745/OS-5900', N'R13-25', N'Ready To Use', CAST(N'2024-07-19T15:51:44.9100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (796, N'Suzuki', N'YV7', N'6W-10040/OS-59500', N'R13-26', N'Ready To Use', CAST(N'2024-07-19T15:51:44.9400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (797, N'Suzuki', N'YV7', N'6W-17873/OS-6000', N'R13-27', N'Ready To Use', CAST(N'2024-07-19T15:51:44.9900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (798, N'Suzuki', N'YV7', N'6W-18197/OS-66300', N'R13-28', N'Ready To Use', CAST(N'2024-07-19T15:51:45.0400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (799, N'Suzuki', N'YV7', N'6W-18143/OS-71300', N'R14-1', N'Ready To Use', CAST(N'2024-07-19T15:51:45.0800000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (800, N'Suzuki', N'YV7', N'6W-17749/OS-74000', N'R14-2', N'Ready To Use', CAST(N'2024-07-19T15:51:45.1200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (801, N'Suzuki', N'YV7', N'6W-17227/OS-76500', N'R14-3', N'Ready To Use', CAST(N'2024-07-19T15:51:45.1500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (802, N'Suzuki', N'YV7', N'6W-18416/OS-78200', N'R14-4', N'Ready To Use', CAST(N'2024-07-19T15:51:45.1900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (803, N'Suzuki', N'YV7', N'6W-19268/OS-79100', N'R14-5', N'Ready To Use', CAST(N'2024-07-19T15:51:45.2300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (804, N'Suzuki', N'YV7', N'6W-17380/OS-8000', N'R14-6', N'Ready To Use', CAST(N'2024-07-19T15:51:45.2700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (805, N'Suzuki', N'YV7', N'6W-19265/OS-82700', N'R14-7', N'Ready To Use', CAST(N'2024-07-19T15:51:45.3100000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (806, N'Suzuki', N'YV7', N'6W-17748/OS-84800', N'R14-8', N'Ready To Use', CAST(N'2024-07-19T15:51:45.3500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (807, N'Suzuki', N'YV7', N'6W-19736/OS-87300', N'R14-9', N'Ready To Use', CAST(N'2024-07-19T15:51:45.3900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (808, N'Suzuki', N'YV7', N'FS-3702/OS-89700', N'R14-10', N'Ready To Use', CAST(N'2024-07-19T15:51:45.4300000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (809, N'Suzuki', N'YV7', N'FS-9826/FS-41200', N'R14-11', N'Ready To Use', CAST(N'2024-07-19T15:51:45.4700000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (810, N'Suzuki', N'YV7', N'6W-9729/FS-41200', N'R14-12', N'Ready To Use', CAST(N'2024-07-19T15:51:45.5100000' AS DateTime2))
GO
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (811, N'Suzuki', N'YV7', N'6W-17572/FS-41200', N'R14-13', N'Ready To Use', CAST(N'2024-07-19T15:51:45.5500000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (812, N'Suzuki', N'YV7', N'FS-13015/FS-75700', N'R14-14', N'Ready To Use', CAST(N'2024-07-19T15:51:45.5900000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (813, N'Suzuki', N'YV7', N'FS-5685/FS-67300', N'R14-15', N'Ready To Use', CAST(N'2024-07-19T15:51:45.6200000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (814, N'Suzuki', N'YV7', N'6W-17288/OE-28500', N'R14-16', N'Ready To Use', CAST(N'2024-07-19T15:51:45.6600000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (815, N'Suzuki', N'YV7', N'6W-4457-OM/OE-28500', N'R14-17', N'Ready To Use', CAST(N'2024-07-19T15:51:45.7000000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (816, N'Suzuki', N'YV7', N'FS-1263/OS-6100', N'R14-18', N'Ready To Use', CAST(N'2024-07-19T15:51:45.7400000' AS DateTime2))
INSERT [dbo].[t_applicator_list] ([id], [car_maker], [car_model], [applicator_no], [location], [status], [date_updated]) VALUES (817, N'Suzuki', N'YV7', N'6W-17736/OS-6100', N'R14-19', N'Ready To Use', CAST(N'2024-07-19T15:51:45.7800000' AS DateTime2))
SET IDENTITY_INSERT [dbo].[t_applicator_list] OFF
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_emp_no]    Script Date: 2024/07/24 8:59:51 am ******/
ALTER TABLE [dbo].[m_accounts] ADD  CONSTRAINT [UX_emp_no] UNIQUE NONCLUSTERED 
(
	[emp_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_applicator_no_zsa_a]    Script Date: 2024/07/24 8:59:51 am ******/
ALTER TABLE [dbo].[m_applicator] ADD  CONSTRAINT [UX_applicator_no_zsa_a] UNIQUE NONCLUSTERED 
(
	[applicator_no] ASC,
	[zaihai_stock_address] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_applicator_no_terminal_name]    Script Date: 2024/07/24 8:59:51 am ******/
ALTER TABLE [dbo].[m_applicator_terminal] ADD  CONSTRAINT [UX_applicator_no_terminal_name] UNIQUE NONCLUSTERED 
(
	[applicator_no] ASC,
	[terminal_name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_terminal_name_la_t]    Script Date: 2024/07/24 8:59:51 am ******/
ALTER TABLE [dbo].[m_terminal] ADD  CONSTRAINT [UX_terminal_name_la_t] UNIQUE NONCLUSTERED 
(
	[terminal_name] ASC,
	[line_address] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_serial_no_ac]    Script Date: 2024/07/24 8:59:51 am ******/
ALTER TABLE [dbo].[t_applicator_c] ADD  CONSTRAINT [UX_serial_no_ac] UNIQUE NONCLUSTERED 
(
	[serial_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_serial_no_aio]    Script Date: 2024/07/24 8:59:51 am ******/
ALTER TABLE [dbo].[t_applicator_in_out] ADD  CONSTRAINT [UX_serial_no_aio] UNIQUE NONCLUSTERED 
(
	[serial_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_applicator_no_aio]    Script Date: 2024/07/24 8:59:52 am ******/
CREATE NONCLUSTERED INDEX [IX_applicator_no_aio] ON [dbo].[t_applicator_in_out]
(
	[applicator_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_terminal_name_aio]    Script Date: 2024/07/24 8:59:52 am ******/
CREATE NONCLUSTERED INDEX [IX_terminal_name_aio] ON [dbo].[t_applicator_in_out]
(
	[terminal_name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_serial_no_aioh]    Script Date: 2024/07/24 8:59:52 am ******/
ALTER TABLE [dbo].[t_applicator_in_out_history] ADD  CONSTRAINT [UX_serial_no_aioh] UNIQUE NONCLUSTERED 
(
	[serial_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [UX_applicator_no_list]    Script Date: 2024/07/24 8:59:52 am ******/
ALTER TABLE [dbo].[t_applicator_list] ADD  CONSTRAINT [UX_applicator_no_list] UNIQUE NONCLUSTERED 
(
	[applicator_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
ALTER TABLE [dbo].[m_accounts] ADD  CONSTRAINT [DF_m_accounts_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_applicator] ADD  CONSTRAINT [DF_m_applicator_date_updated_1]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_applicator_terminal] ADD  CONSTRAINT [DF_m_applicator_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_terminal] ADD  CONSTRAINT [DF_m_terminal_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_applicator_c] ADD  CONSTRAINT [DF_t_applicator_c_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_applicator_c] ADD  CONSTRAINT [DF_t_applicator_c_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_applicator_c] ADD  CONSTRAINT [DF_t_applicator_c_adjustment_content]  DEFAULT (N'N/A') FOR [adjustment_content]
GO
ALTER TABLE [dbo].[t_applicator_c] ADD  CONSTRAINT [DF_t_applicator_c_cross_section_result]  DEFAULT ((4)) FOR [cross_section_result]
GO
ALTER TABLE [dbo].[t_applicator_in_out] ADD  CONSTRAINT [DF_t_applicator_in_out_date_time_out]  DEFAULT (getdate()) FOR [date_time_out]
GO
ALTER TABLE [dbo].[t_applicator_list] ADD  CONSTRAINT [DF_t_applicator_list_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
USE [master]
GO
ALTER DATABASE [zaihai_db] SET  READ_WRITE 
GO
