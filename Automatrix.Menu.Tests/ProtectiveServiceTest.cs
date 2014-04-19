using System;
using System.Text;
using System.Collections.Generic;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using Automatrix.Menu.Tests.ProtectiveTest;

namespace Automatrix.Menu.Tests
{
    /// <summary>
    /// Summary description for ProtectiveServiceTest
    /// </summary>
    [TestClass]
    public class ProtectiveServiceTest
    {
        public ProtectiveServiceTest()
        {
            //
            // TODO: Add constructor logic here
            //
        }

        private TestContext testContextInstance;

        /// <summary>
        ///Gets or sets the test context which provides
        ///information about and functionality for the current test run.
        ///</summary>
        public TestContext TestContext
        {
            get
            {
                return testContextInstance;
            }
            set
            {
                testContextInstance = value;
            }
        }

        #region Additional test attributes
        //
        // You can use the following additional attributes as you write your tests:
        //
        // Use ClassInitialize to run code before running the first test in the class
        // [ClassInitialize()]
        // public static void MyClassInitialize(TestContext testContext) { }
        //
        // Use ClassCleanup to run code after all tests in a class have run
        // [ClassCleanup()]
        // public static void MyClassCleanup() { }
        //
        // Use TestInitialize to run code before running each test 
        // [TestInitialize()]
        // public void MyTestInitialize() { }
        //
        // Use TestCleanup to run code after each test has run
        // [TestCleanup()]
        // public void MyTestCleanup() { }
        //
        #endregion

        [TestMethod]
        public void GetRates()
        {
            ProtectiveServicesSoapClient proxy = new ProtectiveServicesSoapClient();

            RateQuoteResponse response = proxy.GetRates(new RateQuoteRequest()
            {
                DealerNumber = 110723,
                Validation = new Validation()
                {
                    Username = "27",
                    Password = "TEST"
                },
                Automobiles = new AutomobileRateQuoteRequest[] { 
                    new AutomobileRateQuoteRequest()
                    {
                        ProductClassCode = 0,
                         Lender = LendingInstitution.Other,
                         MarkUp = new AutomobileRateQuoteMarkup(){
                            MarkupType  = RateQuoteMarkupType.ByPercent,
                            Type = RateQuoteMarkupType.ByPercent,
                            Value = 0
                         },
                         VIN = "2HGFA168X9H312248",
                            VSCRateOptions = new AutomobileRateQuoteVSC()
                            {
                                BeginningOdometer = 61831,
                                InServiceDate = DateTime.Now,
                                VehiclePlan = VehiclePlans.PreOwned,
                                Surcharges = new AutomobileRateQuoteSurcharges()
                            }
                    }
                }
            });

            Assert.IsNotNull(response);
        }

        [TestMethod]
        public void GetContractForms()
        {
            ProtectiveServicesSoapClient proxy = new ProtectiveServicesSoapClient();
            proxy.GetContractForms(new ContractFormsRequest()
            {
                Automobiles = new AutomobileContractFormsRequest[]{
                    new AutomobileContractFormsRequest()
                    {
                        Lienholder = new Lienholder()
                        {
                            Name = "",
                            PhoneNumber = "",
                            Address = new AddressDetails()
                            {
                                Address1 = "",
                                Address2 = "",
                                City = "",
                                Country = "",
                                CountryCode = CountryCodes.UnitedStatesOfAmerica,
                                State = "",
                                StateCode = StateCodes.FL,
                                ZipCode = ""
                            }
                        }
                    }
                }
            });
        }
    }
}
