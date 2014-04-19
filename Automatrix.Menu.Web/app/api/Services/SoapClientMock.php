<?php namespace Api\Services;

class SoapClientMock
{
	public function __construct()
	{

	}

	public function __setLocation($url)
	{

	}

	public function __setSoapHeaders($headers)
	{

	}

	public function GetKeyRates($parameters)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<RateListKey>
				  <Rate>
				    <CvCvty>USKEY</CvCvty>
				    <CoverageDesc>Key Replacement</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <FiledAmount>45.00</FiledAmount>
				    <AmtDueWtyCo>45.00</AmtDueWtyCo>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC GKR 06-12</FormNumber>
				    <CarYear>2003</CarYear>
				    <CarMake>Mercedes Benz</CarMake>
				    <CarModel>S430</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>USKEY</CvCvty>
				    <CoverageDesc>Key Replacement</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <FiledAmount>57.00</FiledAmount>
				    <AmtDueWtyCo>57.00</AmtDueWtyCo>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC GKR 06-12</FormNumber>
				    <CarYear>2003</CarYear>
				    <CarMake>Mercedes Benz</CarMake>
				    <CarModel>S430</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>USKEY</CvCvty>
				    <CoverageDesc>Key Replacement</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <FiledAmount>77.00</FiledAmount>
				    <AmtDueWtyCo>77.00</AmtDueWtyCo>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC GKR 06-12</FormNumber>
				    <CarYear>2003</CarYear>
				    <CarMake>Mercedes Benz</CarMake>
				    <CarModel>S430</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>USKEY</CvCvty>
				    <CoverageDesc>Key Replacement</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <FiledAmount>82.00</FiledAmount>
				    <AmtDueWtyCo>82.00</AmtDueWtyCo>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC GKR 06-12</FormNumber>
				    <CarYear>2003</CarYear>
				    <CarMake>Mercedes Benz</CarMake>
				    <CarModel>S430</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>USKEY</CvCvty>
				    <CoverageDesc>Key Replacement</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <FiledAmount>87.00</FiledAmount>
				    <AmtDueWtyCo>87.00</AmtDueWtyCo>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC GKR 06-12</FormNumber>
				    <CarYear>2003</CarYear>
				    <CarMake>Mercedes Benz</CarMake>
				    <CarModel>S430</CarModel>
				  </Rate>
				</RateListKey>';

		return array("GetKeyRatesResult" => $xml);
	}
	
	public function GetDentRates($parameters)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<RateListDent>
				  <Rate>
				    <CvCvty>DUSD </CvCvty>
				    <CoverageDesc>Dent and Ding</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>100,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>199.00</FiledAmount>
				    <AmtDueWtyCo>99.00</AmtDueWtyCo>
				    <GroupCode></GroupCode>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC PDR USD 06-13</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				  </Rate>
				  <Rate>
				    <CvCvty>DUSD </CvCvty>
				    <CoverageDesc>Dent and Ding</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>100,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>349.00</FiledAmount>
				    <AmtDueWtyCo>149.00</AmtDueWtyCo>
				    <GroupCode></GroupCode>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC PDR USD 06-13</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				  </Rate>
				  <Rate>
				    <CvCvty>DUSD </CvCvty>
				    <CoverageDesc>Dent and Ding</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>100,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>439.00</FiledAmount>
				    <AmtDueWtyCo>164.00</AmtDueWtyCo>
				    <GroupCode></GroupCode>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC PDR USD 06-13</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				  </Rate>
				  <Rate>
				    <CvCvty>DUSD </CvCvty>
				    <CoverageDesc>Dent and Ding</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>100,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>529.00</FiledAmount>
				    <AmtDueWtyCo>204.00</AmtDueWtyCo>
				    <GroupCode></GroupCode>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC PDR USD 06-13</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				  </Rate>
				  <Rate>
				    <CvCvty>DUSD </CvCvty>
				    <CoverageDesc>Dent and Ding</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>100,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>619.00</FiledAmount>
				    <AmtDueWtyCo>244.00</AmtDueWtyCo>
				    <GroupCode></GroupCode>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC PDR USD 06-13</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				  </Rate>
				  <Rate>
				    <CvCvty>DUSD </CvCvty>
				    <CoverageDesc>Dent and Ding</CoverageDesc>
				    <MonthTerm>72</MonthTerm>
				    <MileageTerm>100,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>699.00</FiledAmount>
				    <AmtDueWtyCo>299.00</AmtDueWtyCo>
				    <GroupCode></GroupCode>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC PDR USD 06-13</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				  </Rate>
				</RateListDent>';
		
		return array("GetKeyDentResult" => $xml);
	}
	
	public function GetMaintRates($parameters)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<RateListMaintenance>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>485.00</FiledAmount>
				    <AmtDueWtyCo>291.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>380.00</FiledAmount>
				    <AmtDueWtyCo>228.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>15,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>567.00</FiledAmount>
				    <AmtDueWtyCo>340.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>15,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>485.00</FiledAmount>
				    <AmtDueWtyCo>291.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>15,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>427.00</FiledAmount>
				    <AmtDueWtyCo>256.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>878.00</FiledAmount>
				    <AmtDueWtyCo>526.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>692.00</FiledAmount>
				    <AmtDueWtyCo>415.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>552.00</FiledAmount>
				    <AmtDueWtyCo>331.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,065.00</FiledAmount>
				    <AmtDueWtyCo>639.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>878.00</FiledAmount>
				    <AmtDueWtyCo>526.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>762.00</FiledAmount>
				    <AmtDueWtyCo>457.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>552.00</FiledAmount>
				    <AmtDueWtyCo>331.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>517.00</FiledAmount>
				    <AmtDueWtyCo>310.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,271.00</FiledAmount>
				    <AmtDueWtyCo>762.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>980.00</FiledAmount>
				    <AmtDueWtyCo>588.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>887.00</FiledAmount>
				    <AmtDueWtyCo>532.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>560.00</FiledAmount>
				    <AmtDueWtyCo>336.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,540.00</FiledAmount>
				    <AmtDueWtyCo>924.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,271.00</FiledAmount>
				    <AmtDueWtyCo>762.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,096.00</FiledAmount>
				    <AmtDueWtyCo>657.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>688.00</FiledAmount>
				    <AmtDueWtyCo>412.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,358.00</FiledAmount>
				    <AmtDueWtyCo>814.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,090.00</FiledAmount>
				    <AmtDueWtyCo>654.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>892.00</FiledAmount>
				    <AmtDueWtyCo>535.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>787.00</FiledAmount>
				    <AmtDueWtyCo>472.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>565.00</FiledAmount>
				    <AmtDueWtyCo>339.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,665.00</FiledAmount>
				    <AmtDueWtyCo>999.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,291.00</FiledAmount>
				    <AmtDueWtyCo>774.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,116.00</FiledAmount>
				    <AmtDueWtyCo>669.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>708.00</FiledAmount>
				    <AmtDueWtyCo>424.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,011.00</FiledAmount>
				    <AmtDueWtyCo>606.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>2,058.00</FiledAmount>
				    <AmtDueWtyCo>1,234.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,685.00</FiledAmount>
				    <AmtDueWtyCo>1,011.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,451.00</FiledAmount>
				    <AmtDueWtyCo>870.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>961.00</FiledAmount>
				    <AmtDueWtyCo>576.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>2,513.00</FiledAmount>
				    <AmtDueWtyCo>1,507.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>2,058.00</FiledAmount>
				    <AmtDueWtyCo>1,234.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,766.00</FiledAmount>
				    <AmtDueWtyCo>1,059.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,241.00</FiledAmount>
				    <AmtDueWtyCo>744.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>OUM  </CvCvty>
				    <CoverageDesc>Maintenance - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,113.00</FiledAmount>
				    <AmtDueWtyCo>667.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>572.00</FiledAmount>
				    <AmtDueWtyCo>343.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>438.00</FiledAmount>
				    <AmtDueWtyCo>262.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>15,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>695.00</FiledAmount>
				    <AmtDueWtyCo>417.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>15,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>613.00</FiledAmount>
				    <AmtDueWtyCo>367.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>15,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>584.00</FiledAmount>
				    <AmtDueWtyCo>350.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,094.00</FiledAmount>
				    <AmtDueWtyCo>656.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>878.00</FiledAmount>
				    <AmtDueWtyCo>526.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>767.00</FiledAmount>
				    <AmtDueWtyCo>460.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>767.00</FiledAmount>
				    <AmtDueWtyCo>460.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,432.00</FiledAmount>
				    <AmtDueWtyCo>859.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,216.00</FiledAmount>
				    <AmtDueWtyCo>729.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,158.00</FiledAmount>
				    <AmtDueWtyCo>694.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>890.00</FiledAmount>
				    <AmtDueWtyCo>534.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>30,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>913.00</FiledAmount>
				    <AmtDueWtyCo>547.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>1,931.00</FiledAmount>
				    <AmtDueWtyCo>1,158.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,581.00</FiledAmount>
				    <AmtDueWtyCo>948.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,575.00</FiledAmount>
				    <AmtDueWtyCo>945.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,441.00</FiledAmount>
				    <AmtDueWtyCo>864.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,248.00</FiledAmount>
				    <AmtDueWtyCo>748.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>2,269.00</FiledAmount>
				    <AmtDueWtyCo>1,361.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,971.00</FiledAmount>
				    <AmtDueWtyCo>1,182.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,884.00</FiledAmount>
				    <AmtDueWtyCo>1,130.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,481.00</FiledAmount>
				    <AmtDueWtyCo>888.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>45,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,476.00</FiledAmount>
				    <AmtDueWtyCo>885.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>2,017.00</FiledAmount>
				    <AmtDueWtyCo>1,210.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,720.00</FiledAmount>
				    <AmtDueWtyCo>1,032.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,580.00</FiledAmount>
				    <AmtDueWtyCo>948.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,446.00</FiledAmount>
				    <AmtDueWtyCo>867.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>39</MonthTerm>
				    <MileageTerm>39,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,253.00</FiledAmount>
				    <AmtDueWtyCo>751.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>2,452.00</FiledAmount>
				    <AmtDueWtyCo>1,471.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>2,021.00</FiledAmount>
				    <AmtDueWtyCo>1,212.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,933.00</FiledAmount>
				    <AmtDueWtyCo>1,159.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,799.00</FiledAmount>
				    <AmtDueWtyCo>1,079.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,525.00</FiledAmount>
				    <AmtDueWtyCo>915.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>3,006.00</FiledAmount>
				    <AmtDueWtyCo>1,803.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>2,575.00</FiledAmount>
				    <AmtDueWtyCo>1,545.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>2,458.00</FiledAmount>
				    <AmtDueWtyCo>1,474.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>1,921.00</FiledAmount>
				    <AmtDueWtyCo>1,152.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>1,968.00</FiledAmount>
				    <AmtDueWtyCo>1,180.80</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>3,055.00</FiledAmount>
				    <AmtDueWtyCo>1,833.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>2,624.00</FiledAmount>
				    <AmtDueWtyCo>1,574.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>2,507.00</FiledAmount>
				    <AmtDueWtyCo>1,504.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>2,239.00</FiledAmount>
				    <AmtDueWtyCo>1,343.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>60,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>2,017.00</FiledAmount>
				    <AmtDueWtyCo>1,210.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>1 </Interval>
				    <LofMonthInterval>3</LofMonthInterval>
				    <LofMileageInterval>3,000</LofMileageInterval>
				    <TiresMileageInterval>6,000</TiresMileageInterval>
				    <FiledAmount>3,609.00</FiledAmount>
				    <AmtDueWtyCo>2,165.40</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>2 </Interval>
				    <LofMonthInterval>4</LofMonthInterval>
				    <LofMileageInterval>3,750</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>3,096.00</FiledAmount>
				    <AmtDueWtyCo>1,857.60</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>3 </Interval>
				    <LofMonthInterval>5</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>2,950.00</FiledAmount>
				    <AmtDueWtyCo>1,770.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>4 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>7,500</LofMileageInterval>
				    <TiresMileageInterval>7,500</TiresMileageInterval>
				    <FiledAmount>2,280.00</FiledAmount>
				    <AmtDueWtyCo>1,368.00</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				  <Rate>
				    <CvCvty>PUM  </CvCvty>
				    <CoverageDesc>Maintenance Plus - Stand Alone form</CoverageDesc>
				    <MonthTerm>60</MonthTerm>
				    <MileageTerm>75,000</MileageTerm>
				    <Interval>5 </Interval>
				    <LofMonthInterval>6</LofMonthInterval>
				    <LofMileageInterval>5,000</LofMileageInterval>
				    <TiresMileageInterval>5,000</TiresMileageInterval>
				    <FiledAmount>2,297.00</FiledAmount>
				    <AmtDueWtyCo>1,378.20</AmtDueWtyCo>
				    <Surcharge />
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC UM FC 10-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				  </Rate>
				</RateListMaintenance>';
		
		return array("GetMaintRatesResult" => $xml);
	}
	
	public function GetGapRates($parameters)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<RateListGap>
				  <Rate>
				    <BegMonthTerm>1</BegMonthTerm>
				    <EndMonthTerm>60</EndMonthTerm>
				    <FiledAmount>108.00</FiledAmount>
				    <AmtDueWtyCo>108.00</AmtDueWtyCo>
				    <RateType>All</RateType>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>State National - Carco - CMF-125 Rev 05-11</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <CoverageDesc>GAP - CARCO                         </CoverageDesc>
				  </Rate>
				  <Rate>
				    <BegMonthTerm>61</BegMonthTerm>
				    <EndMonthTerm>72</EndMonthTerm>
				    <FiledAmount>148.00</FiledAmount>
				    <AmtDueWtyCo>148.00</AmtDueWtyCo>
				    <RateType>All</RateType>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>State National - CMF-125 rev 05-11</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <CoverageDesc>GAP - CARCO                         </CoverageDesc>
				  </Rate>
				  <Rate>
				    <BegMonthTerm>73</BegMonthTerm>
				    <EndMonthTerm>84</EndMonthTerm>
				    <FiledAmount>198.00</FiledAmount>
				    <AmtDueWtyCo>198.00</AmtDueWtyCo>
				    <RateType>All</RateType>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>State National - CMF-125 rev 05-11</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <CoverageDesc>GAP - CARCO                         </CoverageDesc>
				  </Rate>
				</RateListGap>';
		
		return array("GetGapRatesResult" => $xml);
	}
	
	public function GetVscRates($parameters)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
				<RateListVsc>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,354.00</FiledAmount>
				    <AmtDueWtyCo>677.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,204.00</FiledAmount>
				    <AmtDueWtyCo>602.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,104.00</FiledAmount>
				    <AmtDueWtyCo>552.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,029.00</FiledAmount>
				    <AmtDueWtyCo>514.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,470.00</FiledAmount>
				    <AmtDueWtyCo>735.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,320.00</FiledAmount>
				    <AmtDueWtyCo>660.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,220.00</FiledAmount>
				    <AmtDueWtyCo>610.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,145.00</FiledAmount>
				    <AmtDueWtyCo>572.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,626.00</FiledAmount>
				    <AmtDueWtyCo>813.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,476.00</FiledAmount>
				    <AmtDueWtyCo>738.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,376.00</FiledAmount>
				    <AmtDueWtyCo>688.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,301.00</FiledAmount>
				    <AmtDueWtyCo>650.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,708.00</FiledAmount>
				    <AmtDueWtyCo>854.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,558.00</FiledAmount>
				    <AmtDueWtyCo>779.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,458.00</FiledAmount>
				    <AmtDueWtyCo>729.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,383.00</FiledAmount>
				    <AmtDueWtyCo>691.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,830.00</FiledAmount>
				    <AmtDueWtyCo>915.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,680.00</FiledAmount>
				    <AmtDueWtyCo>840.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,580.00</FiledAmount>
				    <AmtDueWtyCo>790.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,505.00</FiledAmount>
				    <AmtDueWtyCo>752.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,072.00</FiledAmount>
				    <AmtDueWtyCo>1,036.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,922.00</FiledAmount>
				    <AmtDueWtyCo>961.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,822.00</FiledAmount>
				    <AmtDueWtyCo>911.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,747.00</FiledAmount>
				    <AmtDueWtyCo>873.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,932.00</FiledAmount>
				    <AmtDueWtyCo>966.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,782.00</FiledAmount>
				    <AmtDueWtyCo>891.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,682.00</FiledAmount>
				    <AmtDueWtyCo>841.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,607.00</FiledAmount>
				    <AmtDueWtyCo>803.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,136.00</FiledAmount>
				    <AmtDueWtyCo>1,068.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,986.00</FiledAmount>
				    <AmtDueWtyCo>993.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,886.00</FiledAmount>
				    <AmtDueWtyCo>943.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46E</CvCvty>
				    <CoverageDesc>Powertrain</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,811.00</FiledAmount>
				    <AmtDueWtyCo>905.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,521.00</FiledAmount>
				    <AmtDueWtyCo>760.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,371.00</FiledAmount>
				    <AmtDueWtyCo>685.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,246.00</FiledAmount>
				    <AmtDueWtyCo>623.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>6</MonthTerm>
				    <MileageTerm>6,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,146.00</FiledAmount>
				    <AmtDueWtyCo>573.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">25.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,673.00</FiledAmount>
				    <AmtDueWtyCo>836.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,523.00</FiledAmount>
				    <AmtDueWtyCo>761.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,398.00</FiledAmount>
				    <AmtDueWtyCo>699.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,298.00</FiledAmount>
				    <AmtDueWtyCo>649.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,883.00</FiledAmount>
				    <AmtDueWtyCo>941.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,733.00</FiledAmount>
				    <AmtDueWtyCo>866.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,608.00</FiledAmount>
				    <AmtDueWtyCo>804.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,508.00</FiledAmount>
				    <AmtDueWtyCo>754.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,993.00</FiledAmount>
				    <AmtDueWtyCo>996.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,843.00</FiledAmount>
				    <AmtDueWtyCo>921.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,718.00</FiledAmount>
				    <AmtDueWtyCo>859.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,618.00</FiledAmount>
				    <AmtDueWtyCo>809.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,157.00</FiledAmount>
				    <AmtDueWtyCo>1,078.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>2,007.00</FiledAmount>
				    <AmtDueWtyCo>1,003.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,882.00</FiledAmount>
				    <AmtDueWtyCo>941.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,782.00</FiledAmount>
				    <AmtDueWtyCo>891.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,473.00</FiledAmount>
				    <AmtDueWtyCo>1,236.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>2,323.00</FiledAmount>
				    <AmtDueWtyCo>1,161.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>2,198.00</FiledAmount>
				    <AmtDueWtyCo>1,099.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>36</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>2,098.00</FiledAmount>
				    <AmtDueWtyCo>1,049.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">150.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,293.00</FiledAmount>
				    <AmtDueWtyCo>1,146.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>2,143.00</FiledAmount>
				    <AmtDueWtyCo>1,071.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>2,018.00</FiledAmount>
				    <AmtDueWtyCo>1,009.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>36,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,918.00</FiledAmount>
				    <AmtDueWtyCo>959.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,557.00</FiledAmount>
				    <AmtDueWtyCo>1,278.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>2,407.00</FiledAmount>
				    <AmtDueWtyCo>1,203.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>2,282.00</FiledAmount>
				    <AmtDueWtyCo>1,141.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46F</CvCvty>
				    <CoverageDesc>Silver</CoverageDesc>
				    <MonthTerm>48</MonthTerm>
				    <MileageTerm>48,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>2,182.00</FiledAmount>
				    <AmtDueWtyCo>1,091.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">200.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>1,860.00</FiledAmount>
				    <AmtDueWtyCo>930.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,710.00</FiledAmount>
				    <AmtDueWtyCo>855.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,560.00</FiledAmount>
				    <AmtDueWtyCo>780.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,435.00</FiledAmount>
				    <AmtDueWtyCo>717.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,112.00</FiledAmount>
				    <AmtDueWtyCo>1,056.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>1,962.00</FiledAmount>
				    <AmtDueWtyCo>981.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,812.00</FiledAmount>
				    <AmtDueWtyCo>906.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46G</CvCvty>
				    <CoverageDesc>Gold</CoverageDesc>
				    <MonthTerm>24</MonthTerm>
				    <MileageTerm>24,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,687.00</FiledAmount>
				    <AmtDueWtyCo>843.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">100.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46H</CvCvty>
				    <CoverageDesc>Platinum</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>0.00</Deductible>
				    <FiledAmount>2,165.00</FiledAmount>
				    <AmtDueWtyCo>1,082.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46H</CvCvty>
				    <CoverageDesc>Platinum</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>50.00</Deductible>
				    <FiledAmount>2,015.00</FiledAmount>
				    <AmtDueWtyCo>1,007.50</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46H</CvCvty>
				    <CoverageDesc>Platinum</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>100.00</Deductible>
				    <FiledAmount>1,840.00</FiledAmount>
				    <AmtDueWtyCo>920.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				  <Rate>
				    <CvCvty>US46H</CvCvty>
				    <CoverageDesc>Platinum</CoverageDesc>
				    <MonthTerm>12</MonthTerm>
				    <MileageTerm>12,000</MileageTerm>
				    <Deductible>200.00</Deductible>
				    <FiledAmount>1,690.00</FiledAmount>
				    <AmtDueWtyCo>845.00</AmtDueWtyCo>
				    <GroupCode>C</GroupCode>
				    <InSrvDateReq>N</InSrvDateReq>
				    <CertWrap> </CertWrap>
				    <Cert>N</Cert>
				    <Wrap>N</Wrap>
				    <InternalPack>0.00</InternalPack>
				    <FormNumber>USWC US FC 02-12</FormNumber>
				    <CarYear>2012</CarYear>
				    <CarMake>Toyota</CarMake>
				    <CarModel>CAMRY/SE/LE/XLE</CarModel>
				    <DealerCommission>0.00</DealerCommission>
				    <Surcharge>
				      <Rentalplus desc="Rental plus">50.00</Rentalplus>
				    </Surcharge>
				  </Rate>
				</RateListVsc>';
		
		return array("GetVscRatesResult" => $xml);
	}
}