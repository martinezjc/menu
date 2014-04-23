using Automatrix.Menu.Service.Test.RoadVantageForm;
using Automatrix.Menu.Service.Test.RoadVantageRates;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Script.Serialization;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Automatrix.Menu.Service.Test
{
    public partial class RoadVantage : System.Web.UI.Page
    {
        SCSAutoServiceSoapClient servicerate = new SCSAutoServiceSoapClient();

        ContractServiceSoapClient serviceform = new ContractServiceSoapClient();

        protected void Page_Load(object sender, EventArgs e)
        {
            string type = Request.Params.Get("type");

            if (type == "rate")
                GetRates();
            else if (type == "contract")
                GenerateContract();
            else if (type == "void")
            {
                string contractnumber = Request.Params.Get("numbercontract");
                VoidContract(contractnumber);
            }
            else if (type == "print")
            {
                string contractnumber = Request.Params.Get("numbercontract");
                PrintContract(contractnumber);
            }
        }

        private void GetRates()
        {
            GetRatesResponse result = new GetRatesResponse();
            result = servicerate.GetRates(new GetRatesRequest()
            {
                UserId = "AMATRX",
                Password = "dq5aJBFU",
                TpaCode = "DEMO",
                DealerNo = "MENU001",
                VIN = "KMHGC4DD4CU176780",
                VehiclePurchasePrice = 25000,
                VehicleOdometer = 15000,
                NewUsed = "N",
                SaleDate = DateTime.Now,
                FinancedAmount = 20000,
                FinanceTerm = 3,
                InserviceDate = DateTime.Now,
                VehiclePurchaseDate = DateTime.Now
            });

            if (result.ErrorResponse != null)
            {
                if (result.ErrorResponse.ErrorDescription != null)
                    if (result.ErrorResponse.ErrorDescription.Length > 0)
                        Response.Write(result.ErrorResponse.ErrorDescription);
            }
            else
            {
                JavaScriptSerializer js = new JavaScriptSerializer();
                String json = js.Serialize(result);
                Response.Write(json);
            }
        }

        private void GenerateContract()
        {
            GenerateContractResponse result = new GenerateContractResponse();

            result = serviceform.GenerateContract(new RoadVantageForm.Contract()
            {
                UserId = "AMATRX",
                Password = "dq5aJBFU",
                TpaCode = "DEMO",
                DealerNumber = "MENU001",
                ContractFormNumber = "DAP DemoForm",
                //ContractNumber = "999999",
                SaleDate = DateTime.Now,
                SaleOdometer = 1000,
                QuoteId = 19796,
                PlanCode = "TW",
                RateBook = 422,
                FinalCopy = true,
                NetCost = 400,
                GenerateContractDocument = true,
                RetailCost = 400,
                //FinanceTerm = 3,
                //FinancedAmount = 20000,
                //FinanceType = "LOAN",
                //FinanceApr = "",
                TermMile = new RoadVantageForm.TermMileage()
                {
                    TermId = 9,
                    Term = 24,
                    Mileage = 24000
                },
                Deductible = new RoadVantageForm.Deductible()
                {
                    DeductId = 1,
                    DeductAmt = 0,
                    DeductType = ""
                },
                Vehicle = new Vehicle()
                {
                    VinNumber = "KMHGC4DD4CU176780",
                    VehicleType = "n"
                },
                Customer = new Customer()
                {
                    FirstName = "Ernesto",
                    LastName = "Toruno",
                    Address = new Address
                    {
                        Address1 = "6703 NW 7th St.",
                        City = "Miami",
                        State = "FL",
                        ZipCode = "33126"
                    }
                },
                LienHolder = new LienHolder()
                {
                    Name = "Bac",
                    Phone = "123456789",
                    Address1 = "primary address", //Primary address information.  It's required
                    Address2 = "secondary Address",//Secondary address information.
                    City = "Miami", //City name of address, It's required
                    State = "FL", //State name of the address.
                    ZipCode = "33126"
                }
            });

            JavaScriptSerializer js = new JavaScriptSerializer();
            string json = js.Serialize(result);

            Response.Write(json);

            //if (result.ContractDocument != null)
            //{
            //    if (result.ContractDocument.Length > 0)
            //    {
            //        Response.ContentType = "Application/pdf";
            //        byte[] bytes = Convert.FromBase64String(result.ContractDocument);
            //        Response.BinaryWrite(bytes);
            //        Response.End();
            //    }
            //    else
            //    {
            //        JavaScriptSerializer js = new JavaScriptSerializer();
            //        string json = js.Serialize(result);

            //        Response.Write(json);
            //    }
            //}
            //else
            //{
            //    JavaScriptSerializer js = new JavaScriptSerializer();
            //    string json = js.Serialize(result);

            //    Response.Write(json);
            //}
        }

        private void VoidContract(string contractnumber)
        {
            VoidContractResponse result = new VoidContractResponse();
            result = servicerate.VoidContract(new VoidContractRequest()
            {
                ContractNumber = contractnumber,
                DealerNumber = "MENU001",
                Password = "dq5aJBFU",
                RequestingUser = "Ernesto",
                TpaCode = "DEMO",
                UserId = "AMATRX",
                VIN = "1NXBR12E32Z600032"
            });

            JavaScriptSerializer js = new JavaScriptSerializer();
            string json = js.Serialize(result);
            Response.Write(json);
        }

        private void PrintContract(string contractnumber)
        {
            PrintContractPDFResponse result = new PrintContractPDFResponse();
            result = serviceform.PrintContractPDF(new PrintContractPDFRequest()
            {
                UserId = "AMATRX",
                Password = "dq5aJBFU",
                TpaCode = "DEMO",
                DealerNumber = "MENU001",
                ContractNumber = contractnumber,
                RequestingUser = "Ernesto"
            });

            Response.ContentType = "Application/pdf";
            byte[] bytes = Convert.FromBase64String(result.ContractPDF);
            Response.BinaryWrite(bytes);
            Response.End();
        }
    }
}