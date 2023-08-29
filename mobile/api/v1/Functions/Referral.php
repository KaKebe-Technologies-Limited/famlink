<?php
class Referral
{

	private $cases = "cases";

	public $id;
	public $title;
	public $picture;
	public $description;
	public $category_id;
	public $reportedby_id;
	public $datecreated;
	public $address;

	public $victim_name;
	public $gender;
	public $age;
	public $region;
	public $contact;
	public $village;
	public $subCounty;
	public $district;
	public $anysupport;
	public $parish;

	public $status;
	// order private
    private $exe_status;

	private $conn;



	public function __construct($con)
	{
		$this->conn = $con;
		$this->exe_status = "failure";
	}

	function create()
	{

		$stmt = $this->conn->prepare("INSERT INTO " . $this->cases . "(`title`, `picture`, `description`, `category_id`, `location`, `reportedby_id`, `status`,`victim_name`,`victim_gender`,`victim_age`,`region`,`contact`,`village`,`sub_county`,`district`,`any_support`,`parish`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		$this->title = htmlspecialchars(strip_tags($this->title));
		$this->picture = htmlspecialchars(strip_tags($this->picture));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));
		$this->reportedby_id = htmlspecialchars(strip_tags($this->reportedby_id));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->address = htmlspecialchars(strip_tags($this->address));

		$this->victim_name = htmlspecialchars(strip_tags($this->victim_name));
		$this->victim_gender = htmlspecialchars(strip_tags($this->victim_gender));
		$this->age = htmlspecialchars(strip_tags($this->age));
		$this->region  = htmlspecialchars(strip_tags($this->region));
		$this->contact = htmlspecialchars(strip_tags($this->contact));
		$this->village = htmlspecialchars(strip_tags($this->village));
		$this->sub_county = htmlspecialchars(strip_tags($this->sub_county));
		$this->district = htmlspecialchars(strip_tags($this->district));
		$this->anysupport = htmlspecialchars(strip_tags($this->anysupport));
		$this->parish = htmlspecialchars(strip_tags($this->parish));



        $stmt->bind_param("sssssiississsssss", $this->title, $this->picture, $this->description, $this->category_id, $this->address, $this->reportedby_id, $this->status,$this->victim_name,$this->gender,$this->age,$this->region,$this->contact,$this->village,$this->subCounty,$this->district,$this->anysupport,$this->parish);

		if ($stmt->execute()) {
			$this->exe_status = "success";
		} else {
			$this->exe_status = "failure";
		}


		if ($this->exe_status == "success") {
			return true;
		}

		return false;
	}


	function readUserOrders()
	{



		$itemRecords = array();

		$this->userOrderid = htmlspecialchars(strip_tags($_GET["customerId"]));
		$this->userOrderPage = htmlspecialchars(strip_tags($_GET["page"]));

		// echo "working". $this->userOrderid .$this->userOrderPage;


		if ($this->userOrderid) {
			$this->pageno = floatval($this->userOrderPage);
			$no_of_records_per_page = 10;
			$offset = ($this->pageno - 1) * $no_of_records_per_page;


			$sql = "SELECT COUNT(*) as count FROM " . $this->cases . " WHERE customer_id = " . $this->userOrderid . " limit 1";
			$result = mysqli_query($this->conn, $sql);
			$data = mysqli_fetch_assoc($result);
			$total_rows = floatval($data['count']);
			$total_pages = ceil($total_rows / $no_of_records_per_page);


			$itemRecords["page"] = $this->pageno;
			$itemRecords["results"] = array();
			$itemRecords["total_pages"] = $total_pages;
			$itemRecords["total_results"] = $total_rows;


			$stmt = $this->conn->prepare("SELECT `order_id`, `order_address`, `customer_id`, `order_date`, `total_amount`, `order_status`, `processed_by` FROM " . $this->cases . " WHERE customer_id = " . $this->userOrderid . " ORDER BY order_id DESC  LIMIT " . $offset . "," . $no_of_records_per_page);
		} else {
			// echo "working b";
			$stmt = $this->conn->prepare("SELECT `order_id`, `order_address`, `customer_id`, `order_date`, `total_amount`, `order_status`, `processed_by` FROM " . $this->cases." ORDER BY order_id DESC" );
		}


		$stmt->execute();
		$stmt -> store_result();
		$stmt->bind_result($this->order_id, $this->order_address, $this->customer_id, $this->order_date, $this->total_amount, $this->order_status, $this->processed_by);

		$numberofrows = $stmt->num_rows;

		if($numberofrows > 0){
			while ($stmt->fetch()) {

				$temp = array();
	
				$temp['order_id'] = $this->order_id;
				$temp['order_address'] = $this->order_address;
				$temp['customer_id'] = $this->customer_id;
				$temp['order_date'] = $this->order_date;
				$temp['total_amount'] = $this->total_amount;
				$temp['order_status'] = $this->order_status;
				$temp['processed_by'] = $this->processed_by;
	
				array_push($itemRecords["results"], $temp);
			}
		} else {
			$temp = array();
	
				$temp['order_id'] = 0;
				$temp['order_address'] = "null";
				$temp['customer_id'] = 0;
				$temp['order_date'] = "null";
				$temp['total_amount'] = 0;
				$temp['order_status'] = 0;
				$temp['processed_by'] = 0;
	
				array_push($itemRecords["results"], $temp);
		}


		


		return $itemRecords;
	}


}