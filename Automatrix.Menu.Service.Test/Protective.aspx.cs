using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.IO;
using System.Xml.Serialization;
using System.Xml;
using System.Web.Script.Serialization;
using Automatrix.Menu.Service.Test.ProtectiveForm;

namespace Automatrix.Menu.Service.Test
{
    public partial class Protective : System.Web.UI.Page
    {
        ProtectiveServicesSoapClient service = new ProtectiveServicesSoapClient();

        protected void Page_Load(object sender, EventArgs e)
        {
            string type = Request.Params.Get("type");

            if (type.ToLower() == "vsc".ToLower())
                GetVSC();
            else if (type.ToLower() == "gap".ToLower())
                GetGAP();
            else if (type.ToLower() == "printvsc".ToLower())
                GetContractFormVSC();
            else if (type.ToLower() == "printgap".ToLower())
                GetContractFromGAP();
            else if (type.ToLower() == "dealerdetail".ToLower())
                GetDealerDetails();
        }

        //private void GetContractFormVSCGAP()
        //{
        //    ContractFormsResponse result = new ContractFormsResponse();

        //    result = service.GetContractForms(new ContractFormsRequest()
        //    {
        //        Validation = new Validation()
        //        {
        //            Username = "27",
        //            Password = "test"
        //        },
        //        DealerNumber = 50000,
        //        Automobiles = new AutomobileContractFormsRequest[]
        //        {
        //            new AutomobileContractFormsRequest()
        //            {
        //                VIN = "4T3ZA3BB3CU056910",
        //                Purchaser = new ContractPurchaser()
        //                {
        //                    FirstPurchaser = new FullName()
        //                    {
        //                        FirstName = "Greivin",
        //                        MiddleInitial = "P",
        //                        LastName = "Britton"
        //                    },
        //                    Address = new AddressDetails()
        //                    {
        //                         Address1 = "6703 NW 7th St.",
        //                         Address2 = "MGA-5739",
        //                         City = "Miami",
        //                         State = "Florida",
        //                         StateCode = StateCodes.FL,
        //                         ZipCode = "33126",
        //                         Country = "Unites States",
        //                         CountryCode = CountryCodes.UnitedStatesOfAmerica
        //                    }
        //                },
        //                                        VSCContract = new AutomobileContractEntryVSC()
        //                {
        //                    VSCContractDetails = new AutomobileContractDetails()
        //                    {
        //                        ContractNumber = 50000,
        //                        ContractPrefix = "CG50",
        //                        EffectiveDate = DateTime.Now,
        //                        PurchaseDate = DateTime.Now,
        //                        RateQuote = new AutomobileRateQuote()
        //                        {
        //                             ProductClass = "VSC",
        //                             ProductClassCode = 1,
        //                             CoverageCode = "WRC08",
        //                             CoverageTermMonths = 36,
        //                             RetailPrice = 271,
        //                             ProductType = AutomobileProductType.VSC,
        //                             RateNumber = 191462
        //                            //ProductClass = "VSC",
        //                            //ProductClassCode = 1,
        //                            //Coverage = "BASIC",
        //                            //CoverageCode = "BAS08",
        //                            //OrderNumber = 0,
        //                            //CoverageTermMonths = 36,
        //                            //CoverageTermMinMonths = 36,
        //                            //CoverageTermMiles = 75,
        //                            //CoverageSortOrder = 3,
        //                            //Deductible = 100,
        //                            //DealerCost = 368,
        //                            //RetailPrice = 368,
        //                            //ContractFormID = 0,
        //                            //RateNumber = 188517,
        //                            //DisappearingDeductible = true,
        //                            //ProductType = AutomobileProductType.VSC,
        //                            //VehicleClassCode = "11"
        //                        }
        //                    },
        //                    VehiclePlan = VehiclePlans.New,
        //                    BeginningOdometer = 1000,
        //                    InServiceDate = new DateTime(2010, 10, 16),
        //                    VehiclePurchasePrice = 20000,
        //                    FinancingType = FinancingType.Purchase,
        //                    Surcharges= new AutomobileRateQuoteSurcharges(){
        //                        BusinessUse=false,
        //                        ConversionPackage= false,
        //                        ElectronicsPackage= false,
        //                        GPS= false,
        //                        MobilityEquipment=false,
        //                        SealsGaskets= false,
        //                        VideoPackage=false
        //                    }
        //                },
        //                 GAPContract = new AutomobileContractEntryGAP()
        //                 {
        //                     AmountFinanced = 15000,
        //                     AmountMSRP = 200,
        //                     APR = 15.5,
        //                     BeginningOdometer = 5000,
        //                     DownPayment = 0,
        //                     FinancingType = FinancingType.Purchase,
        //                     InsuranceDeductible = 0,
        //                     GAPContractDetails = new AutomobileContractDetails()
        //                     {
        //                        ContractPrefix = "2244",
        //                        ContractNumber = 50000,
        //                        EffectiveDate = DateTime.Now,
        //                        PurchaseDate = DateTime.Now,
        //                        RateQuote = new AutomobileRateQuote()
        //                        {
        //                            ProductClass = "GAP",
        //                            ProductClassCode = 50,
        //                            CoverageCode = "G13L1P",
        //                            CoverageTermMonths = 60,
        //                            RetailPrice = 156,
        //                            ProductType = AutomobileProductType.GAP,
        //                            RateNumber = 188608
        //                        }
        //                     }
        //                 }
        //            }
        //        }
        //    });

        //    //JavaScriptSerializer js = new JavaScriptSerializer();
        //    //js.MaxJsonLength = Int32.MaxValue;
        //    //string json = js.Serialize(result);

        //    Response.ContentType = "Application/pdf";
        //    Response.BinaryWrite(result.Automobiles[0].GAPAcknowledgement.FormPDF);
        //    Response.End();
        //}

        private void GetContractFromGAP()
        {
            ContractFormsResponse result = new ContractFormsResponse();

            result = service.GetContractForms(new ContractFormsRequest()
            {
                Validation = new Validation()
                {
                    Username = "27",
                    Password = "test"
                },
                DealerNumber = 50000,
                Automobiles = new AutomobileContractFormsRequest[]
                {
                    new AutomobileContractFormsRequest()
                    {
                        VIN = "WBAKF3C56BE567901",
                        Purchaser = new ContractPurchaser()
                        {
                            FirstPurchaser = new FullName()
                            {
                                FirstName = "Greivin",
                                MiddleInitial = "P",
                                LastName = "Britton"
                            },
                            Address = new AddressDetails()
                            {
                                 Address1 = "6703 NW 7th St.",
                                 Address2 = "MGA-5739",
                                 City = "Miami",
                                 State = "Florida",
                                 StateCode = StateCodes.FL,
                                 ZipCode = "33126",
                                 Country = "Unites States",
                                 CountryCode = CountryCodes.UnitedStatesOfAmerica
                            },
                        },
                        //Lienholder = new Lienholder(){
                        //    Name = "",
                        //    PhoneNumber = "",
                        //    Address = new AddressDetails{
                        //    Address1="", //Primary address information.  It's required
                        //    Address2="", //Secondary address information.
                        //    City="", //City name of address, It's required
                        //    State="", //State name of the address.
                        //    StateCode="", //This is an enumerated example FL(Florida), GA(Georgia), It's required
                        //    Country="", //Country name of the address.
                        //    CountryCode="", //1– UnitedStatesOfAmerica 2– Mexico 3– Canada It's required
                        //    ZipCode="", //It is required

                        //    }
                        //},
                         GAPContract = new AutomobileContractEntryGAP()
                         {
                             AmountFinanced = 15000,
                             AmountMSRP = 200,
                             APR = 15.5,
                             BeginningOdometer = 5000,
                             DownPayment = 0,
                             FinancingType = FinancingType.Purchase,
                             InsuranceDeductible = 0,
                             GAPContractDetails = new AutomobileContractDetails()
                             {
                                ContractPrefix = "2244",
                                ContractNumber = 50000,
                                EffectiveDate = DateTime.Now,
                                PurchaseDate = DateTime.Now,
                                RateQuote = new AutomobileRateQuote()
                                {
                                    ProductClass = "GAP",
                                    ProductClassCode = 50,
                                    CoverageCode = "G13L1P",
                                    CoverageTermMonths = 60,
                                    RetailPrice = 156,
                                    ProductType = AutomobileProductType.GAP,
                                    RateNumber = 188608
                                }
                             }
                         }
                    }
                }
            });

            //JavaScriptSerializer js = new JavaScriptSerializer();
            //js.MaxJsonLength = Int32.MaxValue;
            //string json = js.Serialize(result);

            Response.ContentType = "Application/pdf";
            Response.BinaryWrite(result.Automobiles[0].GAPAcknowledgement.FormPDF);
            Response.End();
        }

        private void GetContractFormVSC()
        {
            ContractFormsResponse result = new ContractFormsResponse();

            result = service.GetContractForms(new ContractFormsRequest()
            {
                Validation = new Validation()
                {
                    Username = "27",
                    Password = "test"
                },
                DealerNumber = 50000,
                Automobiles = new AutomobileContractFormsRequest[]
                {
                    new AutomobileContractFormsRequest()
                    {
                        VIN = "WBAKF3C56BE567901",
                        Purchaser = new ContractPurchaser()
                        {
                            FirstPurchaser = new FullName()
                            {
                                FirstName = "Ernesto",
                                MiddleInitial = "A",
                                LastName = "Toruño"
                            },
                            Address = new AddressDetails()
                            {
                                Address1 = "6703 NW 7th St.",
                                Address2 = "MGA-5739", //not required
                                City = "Miami",
                                State = "Florida",
                                StateCode = StateCodes.FL,
                                Country = "United States", //not required
                                CountryCode = CountryCodes.UnitedStatesOfAmerica,
                                ZipCode = "33126"
                            },
                        },
                        Lienholder = new Lienholder()
                        {
                            Name = "Cash",
                            PhoneNumber = "", //not required
                            Address = new AddressDetails()
                            {
                                Address1 = "address number one",
                                Address2 = "", //not required
                                City = "Miami",//not required
                                State = "Florida",
                                StateCode = StateCodes.FL,
                                Country = "UnitedStatesOfAmerica", //not required
                                CountryCode = CountryCodes.UnitedStatesOfAmerica,
                                ZipCode = "33132"
                            }
                        },
                        VSCContract = new AutomobileContractEntryVSC()
                        {
                            VSCContractDetails = new AutomobileContractDetails()
                            {
                                ContractNumber = 50000,
                                ContractPrefix = "CG50",
                                EffectiveDate = DateTime.Now,
                                PurchaseDate = DateTime.Now,
                                RateQuote = new AutomobileRateQuote()
                                {
                                     ProductClass = "VSC",
                                     ProductClassCode = 1,
                                     CoverageCode = "WRC08",
                                     CoverageTermMonths = 36,
                                     RetailPrice = 271,
                                     ProductType = AutomobileProductType.VSC,
                                     RateNumber = 191462
                                    //ProductClass = "VSC",
                                    //ProductClassCode = 1,
                                    //Coverage = "BASIC",
                                    //CoverageCode = "BAS08",
                                    //OrderNumber = 0,
                                    //CoverageTermMonths = 36,
                                    //CoverageTermMinMonths = 36,
                                    //CoverageTermMiles = 75,
                                    //CoverageSortOrder = 3,
                                    //Deductible = 100,
                                    //DealerCost = 368,
                                    //RetailPrice = 368,
                                    //ContractFormID = 0,
                                    //RateNumber = 188517,
                                    //DisappearingDeductible = true,
                                    //ProductType = AutomobileProductType.VSC,
                                    //VehicleClassCode = "11"
                                }
                            },
                            VehiclePlan = VehiclePlans.New,
                            BeginningOdometer = 1000,
                            InServiceDate = new DateTime(2010, 10, 16),
                            VehiclePurchasePrice = 20000,
                            FinancingType = FinancingType.Purchase,
                            Surcharges= new AutomobileRateQuoteSurcharges(){
                                BusinessUse=false,
                                ConversionPackage= false,
                                ElectronicsPackage= false,
                                GPS= false,
                                MobilityEquipment=false,
                                SealsGaskets= false,
                                VideoPackage=false
                            }
                        },    
                        //GAPContract = new AutomobileContractEntryGAP()
                        //{
                        //    AmountFinanced = 15000,
                        //    AmountMSRP = 200,
                        //    APR = 15.5,
                        //    BeginningOdometer = 5000,
                        //    DownPayment = 0,
                        //    FinancingType = FinancingType.Purchase,
                        //    InsuranceDeductible = 0,
                        //    GAPContractDetails = new AutomobileContractDetails()
                        //    {
                        //       ContractPrefix = "2244",
                        //       ContractNumber = 50000,
                        //       EffectiveDate = DateTime.Now,
                        //       PurchaseDate = DateTime.Now,
                        //       RateQuote = new AutomobileRateQuote()
                        //       {
                        //           ProductClass = "GAP",
                        //           ProductClassCode = 50,
                        //           CoverageCode = "G13L1P",
                        //           CoverageTermMonths = 60,
                        //           RetailPrice = 156,
                        //           ProductType = AutomobileProductType.GAP,
                        //           RateNumber = 188608
                        //       }
                        //    }
                        //}
                    }
                }
            });

            //if (result.Automobiles[0].VSCAcknowledgement.ContractErrors.Length > 0)
            //{
            //    JavaScriptSerializer js = new JavaScriptSerializer();
            //    js.MaxJsonLength = int.MaxValue;
            //    string json = js.Serialize(result);
            //    Response.Write(json);
            //    Response.End();
            //}
            //else
            //{
            Response.ContentType = "Application/pdf";
            Response.BinaryWrite(result.Automobiles[0].VSCAcknowledgement.FormPDF);
            Response.End();
            //}
        }

        private void SubmitContract()
        {
            ContractEntryResponse result = new ContractEntryResponse();
            result = service.SubmitContracts( new ContractEntryRequest()
            {
                Validation = new Validation()
                {
                    Username = "27",
                    Password = "test"
                },
                DealerNumber = 50000,
                Automobiles = new AutomobileContractEntryRequest[]
                {
                    new AutomobileContractEntryRequest{
                    VIN = "WBAKF3C56BE567901",
                    Purchaser = new ContractPurchaser()
                    {
                        FirstPurchaser = new FullName()
                        {
                            FirstName = "test",
                            MiddleInitial = "t",
                            LastName = "test"
                        },
                        //SecondPurchaser = new FullName()
                        //{
                        //    FirstName = "Please",
                        //    MiddleInitial = "P",
                        //    LastName = "the purchase"
                        //},
                        Address = new AddressDetails()
                        {
                            Address1 = "address number one",
                            //Address2 = "", //not required
                            City = "Miami",
                            State = "Florida",
                            StateCode = StateCodes.FL,
                            Country = "UnitedStatesOfAmerica", //not required
                            CountryCode = CountryCodes.UnitedStatesOfAmerica,
                            ZipCode = "12345"
                        },
                    },
                    Lienholder = new Lienholder()
                    {
                        Name = "Cash",
                        PhoneNumber = "", //not required
                        Address = new AddressDetails()
                            {
                                Address1 = "address number one",
                                //Address2 = "", //not required
                                //City = "Miami",//not required
                                State = "Florida",
                                StateCode = StateCodes.FL,
                                Country = "UnitedStatesOfAmerica", //not required
                                CountryCode = CountryCodes.UnitedStatesOfAmerica,
                                //ZipCode = "33132"
                            }
                    },
                    VSCContract = new AutomobileContractEntryVSC(){
                        VSCContractDetails = new AutomobileContractDetails(){
                            ContractNumber = 11113,
                            ContractPrefix = "CG50",
                            EffectiveDate = new DateTime(2011, 10, 16),
                            PurchaseDate = new DateTime(2011, 10, 6),
                            RateQuote = new AutomobileRateQuote(){
                                ProductClass= "VSC",
                                ProductClassCode= 1,
                                Coverage="BASIC",
                                CoverageCode="BAS08",
                                OrderNumber=0,
                                CoverageTermMonths=36,
                                CoverageTermMinMonths=36,
                                CoverageTermMiles=75,
                                CoverageSortOrder=3,
                                Deductible=100,
                                DealerCost=368,
                                RetailPrice=368,
                                ContractFormID=0,
                                RateNumber=188517,
                                DisappearingDeductible=true,
                                ProductType= AutomobileProductType.VSC,
                                VehicleClassCode="11"
                            }
                        },
                        VehiclePlan= VehiclePlans.New,
                        BeginningOdometer=12,
                        InServiceDate=new DateTime(2010,10,16),
                        VehiclePurchasePrice=25000,
                        ContractSalesTax=0,
                        FinancingType=FinancingType.Purchase,
                    },
                    SaveWithoutRating=false,
                    ProvideFormsWithResponse=true
                    }
                }
            });

            JavaScriptSerializer js = new JavaScriptSerializer();
            string json = js.Serialize(result);

            Response.Write(json);
        }

        private void SubmitContractPDF()
        {
            service.SubmitContractPDF(new ContractSubmitFormRequest
            {
                ContractInfo = new ContractIdentity()
                {
                    ContractNumber = 10,
                    ContractPrefix = "",
                    ContractQualifier = 0,
                    ContractSequence = 0
                },
                Validation = new Validation
                {
                    Username = "27",
                    Password = "test"
                },
                DealerNumber = 50000
            });
        }

        private void GetVSC()
        {
            RateQuoteResponse result = new RateQuoteResponse();
            result = service.GetRates(new RateQuoteRequest
            {
                Validation = new Validation { Username = "27", Password = "TEST" },
                DealerNumber = 110723,
                Automobiles = new AutomobileRateQuoteRequest[] 
                { 
                    new AutomobileRateQuoteRequest { 
                        VIN = "WBAKF3C56BE567901", 
                        Lender = LendingInstitution.None, 
                        MarkUp = new AutomobileRateQuoteMarkup 
                        { 
                            MarkupType = RateQuoteMarkupType.ByPercent, 
                            Type = RateQuoteMarkupType.ByPercent, 
                            Value = 0,
                        },
                        VSCRateOptions = new AutomobileRateQuoteVSC 
                        {
                            InServiceDate = DateTime.Now,
                            BeginningOdometer = 5000,
                            VehiclePlan = VehiclePlans.New,
                            Surcharges = new AutomobileRateQuoteSurcharges
                            {
                                BusinessUse = false,
                                ConversionPackage = false,
                                ConversionVAN = false,
                                ElectronicsPackage = false,
                                GPS = false,
                                MobilityEquipment = false,
                                SealsGaskets = false,
                                VideoPackage = false,
                                DualWheel = false,
                                KiaElligibility = false,
                                Kia100000 = false,
                                LimitedLiability75k = false,
                                EngineSize = false,
                                LiftKit = false,
                                LiftKit100 = false,
                                LiftKit200 = false,
                                LiftKit4Inch = false,
                                LiftKit6Inch = false,
                                EntertainmentPackage = false,
                                PaintlessDentRemoval = false,
                                WindShield = false,
                                CommercialUse = false,
                                PowerSteps = false,
                                OneTon = false,
                                TireWheel = false,
                                Turbo = false,
                                Diesel = false,
                                FourByFour = false,
                                FourWheelSteering = false,
                                LEWUpsell = false
                            }
                        }
                    },
                    new AutomobileRateQuoteRequest { 
                        VIN = "WBAKF3C56BE567901", 
                        Lender = LendingInstitution.None, 
                        MarkUp = new AutomobileRateQuoteMarkup 
                        { 
                            MarkupType = RateQuoteMarkupType.ByPercent, 
                            Type = RateQuoteMarkupType.ByPercent, 
                            Value = 0,
                        },
                        VSCRateOptions = new AutomobileRateQuoteVSC 
                        {
                            InServiceDate = DateTime.Now,
                            BeginningOdometer = 5000,
                            VehiclePlan = VehiclePlans.Renewal,
                            Surcharges = new AutomobileRateQuoteSurcharges
                            {
                                BusinessUse = false,
                                ConversionPackage = false,
                                ConversionVAN = false,
                                ElectronicsPackage = false,
                                GPS = false,
                                MobilityEquipment = false,
                                SealsGaskets = false,
                                VideoPackage = false,
                                DualWheel = false,
                                KiaElligibility = false,
                                Kia100000 = false,
                                LimitedLiability75k = false,
                                EngineSize = false,
                                LiftKit = false,
                                LiftKit100 = false,
                                LiftKit200 = false,
                                LiftKit4Inch = false,
                                LiftKit6Inch = false,
                                EntertainmentPackage = false,
                                PaintlessDentRemoval = false,
                                WindShield = false,
                                CommercialUse = false,
                                PowerSteps = false,
                                OneTon = false,
                                TireWheel = false,
                                Turbo = false,
                                Diesel = false,
                                FourByFour = false,
                                FourWheelSteering = false,
                                LEWUpsell = false
                            }
                        }
                    },
                    new AutomobileRateQuoteRequest { 
                        VIN = "WBAKF3C56BE567901", 
                        Lender = LendingInstitution.None, 
                        MarkUp = new AutomobileRateQuoteMarkup 
                        { 
                            MarkupType = RateQuoteMarkupType.ByPercent, 
                            Type = RateQuoteMarkupType.ByPercent, 
                            Value = 0,
                        },
                        VSCRateOptions = new AutomobileRateQuoteVSC 
                        {
                            InServiceDate = DateTime.Now,
                            BeginningOdometer = 5000,
                            VehiclePlan = VehiclePlans.ExtendedEligibilityProgram,
                            Surcharges = new AutomobileRateQuoteSurcharges
                            {
                                BusinessUse = false,
                                ConversionPackage = false,
                                ConversionVAN = false,
                                ElectronicsPackage = false,
                                GPS = false,
                                MobilityEquipment = false,
                                SealsGaskets = false,
                                VideoPackage = false,
                                DualWheel = false,
                                KiaElligibility = false,
                                Kia100000 = false,
                                LimitedLiability75k = false,
                                EngineSize = false,
                                LiftKit = false,
                                LiftKit100 = false,
                                LiftKit200 = false,
                                LiftKit4Inch = false,
                                LiftKit6Inch = false,
                                EntertainmentPackage = false,
                                PaintlessDentRemoval = false,
                                WindShield = false,
                                CommercialUse = false,
                                PowerSteps = false,
                                OneTon = false,
                                TireWheel = false,
                                Turbo = false,
                                Diesel = false,
                                FourByFour = false,
                                FourWheelSteering = false,
                                LEWUpsell = false
                            }
                        }
                    },
                    new AutomobileRateQuoteRequest { 
                        VIN = "WBAKF3C56BE567901", 
                        Lender = LendingInstitution.None, 
                        MarkUp = new AutomobileRateQuoteMarkup 
                        { 
                            MarkupType = RateQuoteMarkupType.ByPercent, 
                            Type = RateQuoteMarkupType.ByPercent, 
                            Value = 0,
                        },
                        VSCRateOptions = new AutomobileRateQuoteVSC 
                        {
                            InServiceDate = DateTime.Now,
                            BeginningOdometer = 5000,
                            VehiclePlan = VehiclePlans.BestAvailablePlan,
                            Surcharges = new AutomobileRateQuoteSurcharges
                            {
                                BusinessUse = false,
                                ConversionPackage = false,
                                ConversionVAN = false,
                                ElectronicsPackage = false,
                                GPS = false,
                                MobilityEquipment = false,
                                SealsGaskets = false,
                                VideoPackage = false,
                                DualWheel = false,
                                KiaElligibility = false,
                                Kia100000 = false,
                                LimitedLiability75k = false,
                                EngineSize = false,
                                LiftKit = false,
                                LiftKit100 = false,
                                LiftKit200 = false,
                                LiftKit4Inch = false,
                                LiftKit6Inch = false,
                                EntertainmentPackage = false,
                                PaintlessDentRemoval = false,
                                WindShield = false,
                                CommercialUse = false,
                                PowerSteps = false,
                                OneTon = false,
                                TireWheel = false,
                                Turbo = false,
                                Diesel = false,
                                FourByFour = false,
                                FourWheelSteering = false,
                                LEWUpsell = false
                            }
                        }
                    }
                }
            });

            JavaScriptSerializer js = new JavaScriptSerializer();
            string json = js.Serialize(result);

            Response.Write(json);
        }

        private void GetGAP()
        {
            RateQuoteResponse result = new RateQuoteResponse();
            result = service.GetRates(new RateQuoteRequest
            {
                Validation = new Validation { Username = "27", Password = "TEST" },
                DealerNumber = 110723,
                Automobiles = new AutomobileRateQuoteRequest[] 
                { 
                    new AutomobileRateQuoteRequest { 
                        VIN = "WBAKF3C56BE567901", 
                        //ProductClassCode = 1,
                        ID = "",
                        //Lender = LendingInstitution.Other, 
                        MarkUp = new AutomobileRateQuoteMarkup 
                        { 
                            MarkupType = RateQuoteMarkupType.ByPercent, 
                            Type = RateQuoteMarkupType.ByPercent, 
                            Value = 0
                        },
                        GAPRateOptions = new AutomobileRateQuoteGAP
                        {
                                AmountMSRP = 20000,
                                AmountFinanced = 15000,
                                BeginningOdometer = 5000,
                                FinancingType  = FinancingType.Purchase,
                                ContractPrefix = "401",
                                
                                //VehiclePurchasePrice = 15000,
                                
                        }
                    }
                }
            });

            JavaScriptSerializer js = new JavaScriptSerializer();
            string json = js.Serialize(result);

            Response.Write(json);
        }

        private void GetDealerDetails()
        {
            DealerDetailsResponse result = new DealerDetailsResponse();
            result = service.GetDealerDetails(new DealerDetailsRequest
            {
                DealerNumbers = new int[] { 110723 },
                Validation = new Validation { Username = "27", Password = "TEST" }
            });

            JavaScriptSerializer js = new JavaScriptSerializer();
            string json = js.Serialize(result);

            Response.Write(json);
        }
    }
}