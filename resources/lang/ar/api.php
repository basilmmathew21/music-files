<?php
$common = [
	'unauthorized_access' => 'Unauthorized access!'
];
$auth = [
		'register_successful' => 'Registration  successfully',
		'register_not_successful' => 'Registration not  successfully',
		'validation_error'	=> 'Registration not  successfully. Validation errors!',
		'invalid_phone_code' => 'Invalid phone code',
		'invalid_phone' => 'Invalid phone number',
		'otp_already_verified' => 'OTP already verified',
		'otp_verified' => 'OTP Verified successfully',
		'otp_expired' => 'OTP Expired',
		'otp_not_match' => 'OTP does not match',
		'otp_not_generated' => 'OTP is not generated',
		'password_reset' => 'Password reset successfully',
		'invalid_credentials' => 'Invalid credentails',
		'loged_in' => 'Successfully logged in',
		'sms_not_sent' => 'SMS was not sent successfully',
		'sms_sent' => 'SMS was sent successfully',
		'validation_fail' => 'Vaildation Failed',
		'email_changed' => 'Email Changed',
		'phone_changed' => 'Phone Changed'
];
$customer = [
		'customer_details' => 'Retrieved Customer Successfully',
		'customer_update' => 'Customer Updated Successfully',
		'validation_fail' => 'Vaildation Failed',
		'customer_profile_updated' => 'Customer Profile Updated'
];
$coupon = [
		'add_success' => 'Coupon Added successful!',
		'add_unsuccess' => 'Add Coupon unsuccessful!',
		'coupon_not_active' => 'Coupon is not Active',
		'coupon_expired' => 'Coupon is Expired',
		'coupon_limit_exceeded' => 'Coupon Limit Exceeded',
		'coupon_already_applied' => 'Coupon Already Applied',
		'apply_discount_unsuccess' => 'Apply Coupon unsuccessful!',
		'apply_discount_success' => 'Apply Coupon successful!',
];
$carRental = [
	'validation_error'	=> 'Rent List Error. Validation errors!',
	 
];
$carBill = [
	'validation_error'	=> 'Bill List Error. Validation errors!',
	 
];

$driver = [
	'register_successful' => 'Registration  successfully',
	'register_not_successful' => 'Registration not  successfully',
	'invalid_credentials' => 'Invalid credentails',
	'invalid_phone_code' => 'Invalid phone code',
	'loged_in' => 'Successfully logged in',
	'sms_not_sent' => 'SMS was not sent successfully',
	'sms_sent' => 'SMS was sent successfully',
	'retrived_successfully' => 'Drivers retrieved successfully',
	'validation_fail' => 'Vaildation Failed',
	'driver_update' => 'Driver Updated Successfully',
	'updated_availability' => 'Updated Status Change',
	'failed_updation_availability' => 'Failed Status Change',
	'updated_location' => 'Updated Location Successfully',
	'failed_location_update' => 'Failed Location Update',
	'trip_in_progress' => 'Trip In Progress',
	'invalid_driver' => 'Invalid Driver',
	'invalid_trip' => 'Invalid Trip',
	'trip_near_by' => 'Trip Near By',
	'trip_status_changed' => 'Trip Status Changed',
	'invalid_status' => 'Invalid Status',
	'invalid_cancelled_status' => 'Invalid Cancelled Status',
	'rating_saved' => 'Rating is Saved Successfully',
	'money_adjusted' => 'Money adjusted and change added to wallet',
	'money_added_to_wallet' => 'Adjusted Money is added to the wallet',
	'accepted_driver' => 'Driver already accepted'
];

return [
            'auth' => $auth,
            'customer' => $customer,
            'common' => $common,
			'coupon' => $coupon,
			'carRental' => $carRental,
			'carBill' => $carBill,
			'driver' => $driver,
        ];