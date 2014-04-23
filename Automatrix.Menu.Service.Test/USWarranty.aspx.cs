using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Xml;
using Newtonsoft.Json;
using Automatrix.Menu.Service.Test.USWarrantyForm;

namespace Automatrix.Menu.Service.Test
{
    public partial class USWarranty : System.Web.UI.Page
    {
        UswcWebServiceSoapClient service = new UswcWebServiceSoapClient();
        USWarrantyRates.UswcWebServiceSoapClient servicerates = new USWarrantyRates.UswcWebServiceSoapClient();

        string username = "FC4862";
        string password = "ST5831";
        string dealerbase = "11401";
        string vinbase = "5NPEB4AC6DH611272";
        string odometerbase = "19056";
        string result = string.Empty;

        protected void Page_Load(object sender, EventArgs e)
        {
            string type = Request.Params.Get("type");
            string dealer = Request.Params.Get("dealer");
            string vin = Request.Params.Get("vin");

            if (type == null)
                return;

            if (type.ToLower() == "ChemicalRates".ToLower())
                GetChemicalRates(dealer);
            else if (type.ToLower() == "DentRates".ToLower())
                GetDentRates(dealer, vin);
            else if (type.ToLower() == "EtchRates".ToLower())
                GetEtchRates(dealer);
            else if (type.ToLower() == "EtwRates".ToLower())
                GetEtwRates(dealer);
            else if (type.ToLower() == "GapRates".ToLower())
                GetGapRates(dealer, vin);
            else if (type.ToLower() == "KeyRates".ToLower())
                GetKeyRates(dealer);
            else if (type.ToLower() == "MaintRates".ToLower())
                GetMaintRates(dealer);
            else if (type.ToLower() == "RoadHazardRates".ToLower())
                GetRoadHazardRates(dealer);
            else if (type.ToLower() == "VscRates".ToLower())
                GetVscRates(dealer);
            else if (type.ToLower() == "printcontract".ToLower())
                SubmitContract();
            else if (type.ToLower() == "voidcontract".ToLower())
                VoidContract();

            XmlDocument doc = new XmlDocument();
            doc.LoadXml(result);
            string json = Newtonsoft.Json.JsonConvert.SerializeXmlNode(doc);

            Response.Write(json);

            //SubmitContract();

            //EvoidContract();
        }

        private void GetChemicalRates(string dealer = "")
        {
            result = servicerates.GetChemicalRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now);
        }

        private void GetDentRates(string dealer = "", string vin = "")
        {
            result = servicerates.GetDentRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now, odometerbase);
        }

        private void GetEtchRates(string dealer = "")
        {
            result = servicerates.GetEtchRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now);
        }

        private void GetEtwRates(string dealer = "")
        {
            result = servicerates.GetEwtRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now, odometerbase);
        }

        private void GetGapRates(string dealer = "", string vin = "")
        {
            result = servicerates.GetGapRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, DateTime.Now, odometerbase, vin != null ? vin : vinbase);
        }

        private void GetKeyRates(string dealer = "")
        {
            result = servicerates.GetKeyRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now);
        }

        private void GetMaintRates(string dealer = "")
        {
            result = servicerates.GetMaintRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now, odometerbase, "Alone");
        }

        private void GetRoadHazardRates(string dealer = "")
        {
            result = servicerates.GetRoadHazardRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now, odometerbase);
        }

        private void GetVscRates(string dealer = "")
        {
            result = servicerates.GetVscRates(new USWarrantyRates.AuthenticationHeader() { Username = username, Password = password }, "USW", dealer != null ? dealer : dealerbase, vinbase, DateTime.Now, odometerbase, "Used", DateTime.Now);
        }

        private void SubmitContract()
        {
            XmlDocument xDoc = new XmlDocument();
            xDoc.Load("formrequest.xml");
            //WSHttpBinding binding = new WSHttpBinding();
            //binding.Name = "UswcWebServiceSoap";
            //binding.MaxReceivedMessageSize = Int32.MaxValue;

            result = service.SubmitProducts(new AuthenticationHeader() { Username = username, Password = password }, xmlDoc: xDoc);

            string pdfinfo;
            string contractnumber;

            if (result.Length == 0)
                return;

            //result = File.ReadAllText("pdfinformation.txt");
            xDoc.LoadXml(result);
            pdfinfo = xDoc.GetElementsByTagName("Pdf")[0].OuterXml;
            pdfinfo = pdfinfo.Replace("<Pdf>", "");
            pdfinfo = pdfinfo.Replace("</Pdf>", "");
            if (pdfinfo.Length > 0)
            {
                //contractnumber = xDoc.GetElementsByTagName("ContractNumber")[0].OuterXml;
                //contractnumber = pdfinfo.Replace("<ContractNumber>", "");
                //contractnumber = pdfinfo.Replace("</ContractNumber", "");

                //if(contractnumber.Length>0)


                Response.ContentType = "Application/pdf";
                byte[] bytes = Convert.FromBase64String(pdfinfo);
                Response.BinaryWrite(bytes);
                Response.End();
            }
            else
            {
                Response.Write(result);
            }
        }

        private void VoidContract()
        {
            XmlDocument xDoc = new XmlDocument();
            xDoc.Load("voidContract.xml");

            result = service.VoidProducts(new AuthenticationHeader() { Username = username, Password = password },
                xDoc);

            Response.Write(result);
        }
    }
}


