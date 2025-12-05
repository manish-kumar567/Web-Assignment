<?php
// PHP SCRIPT START
// This section handles form submission, validation, and data processing.

$is_submitted = false;
$error_message = '';
$submitted_data = [];

// Define the expected fields and their display labels
$form_fields = [
    'fullName' => 'Full Name',
    'dob' => 'Date of Birth',
    'gender' => 'Gender',
    'email' => 'Email Address',
    'phone' => 'Phone Number',
    'qualification' => 'Highest Qualification',
    'course' => 'Selected Course',
    'startDate' => 'Expected Start Date',
    'address' => 'Full Address'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $temp_data = [];
    $is_valid = true;

    // 1. Validate and Sanitize Input
    foreach ($form_fields as $key => $label) {
        if (empty($_POST[$key])) {
            // For date fields, an empty string is okay if not explicitly required, but we made them required in HTML
            $error_message = "Error: The '{$label}' field is required.";
            $is_valid = false;
            break;
        }

        // Sanitize data
        $value = trim($_POST[$key]);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $temp_data[$key] = $value;
    }

    // 2. Additional Validation (e.g., Phone Number format)
    if ($is_valid && !preg_match("/^[0-9]{10}$/", $temp_data['phone'])) {
        $error_message = "Error: Phone number must be exactly 10 digits.";
        $is_valid = false;
    }

    // 3. Process Success or Failure
    if ($is_valid) {
        $is_submitted = true;
        $submitted_data = $temp_data;
        // In a real application, you would insert $submitted_data into a database here.
    } else {
        // If validation failed, the form will be re-displayed with the error message.
    }
}
// PHP SCRIPT END
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Application Form</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
        }
        .form-input {
            @apply w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150;
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">

    <!-- Main Container -->
    <div id="app-container" class="w-full max-w-2xl bg-white shadow-2xl rounded-xl p-8 md:p-10">

        <!-- ERROR MESSAGE DISPLAY (Visible if PHP validation fails) -->
        <?php if (!empty($error_message) && !$is_submitted): ?>
            <div class="text-red-600 font-medium p-3 bg-red-100 border border-red-300 rounded-lg mb-6" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Conditional View Rendering using PHP -->
        <?php if (!$is_submitted): ?>
        
            <!-- 1. Registration Form (Initially Visible) -->
            <div id="registration-form-container">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2 text-center">Course Registration</h2>
                <p class="text-gray-500 mb-8 text-center">Fill out the details below to complete your application.</p>
                
                <!-- Form action submits to the same file using POST method -->
                <form id="registration-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="space-y-6">

                    <!-- Personal Details -->
                    <fieldset class="border p-6 rounded-lg shadow-sm">
                        <legend class="text-xl font-semibold text-gray-700 px-2">Applicant Details</legend>
                        
                        <div>
                            <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="fullName" name="fullName" required class="form-input" placeholder="Enter your full name">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" id="dob" name="dob" required class="form-input">
                            </div>
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <select id="gender" name="gender" required class="form-input">
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                    <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" required class="form-input" placeholder="example@email.com">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required class="form-input" pattern="[0-9]{10}" placeholder="e.g., 9876543210 (10 digits)">
                        </div>
                    </fieldset>

                    <!-- Course Selection & Background -->
                    <fieldset class="border p-6 rounded-lg shadow-sm">
                        <legend class="text-xl font-semibold text-gray-700 px-2">Program Selection & Background</legend>
                        
                        <div>
                            <label for="qualification" class="block text-sm font-medium text-gray-700 mb-1">Highest Qualification</label>
                            <select id="qualification" name="qualification" required class="form-input">
                                <option value="">-- Select Qualification --</option>
                                <option value="High School">High School / Secondary</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Bachelor's Degree">Bachelor's Degree</option>
                                <option value="Master's Degree">Master's Degree</option>
                                <option value="PhD">PhD</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Select Course</label>
                                <select id="course" name="course" required class="form-input">
                                    <option value="">-- Choose a Program --</option>
                                    <option value="Software Engineering">Software Engineering</option>
                                    <option value="Data Science">Data Science</option>
                                    <option value="Cyber Security">Cyber Security</option>
                                    <option value="Cloud Computing">Cloud Computing</option>
                                </select>
                            </div>
                            <div>
                                <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Expected Start Date</label>
                                <input type="date" id="startDate" name="startDate" required class="form-input">
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                            <textarea id="address" name="address" rows="3" required class="form-input" placeholder="House No, Street, City, State, ZIP"></textarea>
                        </div>
                    </fieldset>

                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md transform hover:scale-[1.01]">
                        Submit Application
                    </button>
                </form>
            </div>

        <?php else: ?>

            <!-- 2. Success Display (Visible only after successful PHP submission) -->
            <div id="success-display-container" class="text-gray-800">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-3xl font-extrabold text-green-700 mb-3">Application Successful!</h2>
                    <p class="text-lg text-gray-600 mb-8">Your information has been successfully received and processed by the server.</p>
                </div>
                
                <!-- Submitted Data Display -->
                <div class="bg-blue-50 p-6 rounded-xl shadow-inner">
                    <h3 class="text-xl font-bold text-blue-800 mb-4 border-b border-blue-200 pb-2">Submitted Details</h3>
                    <div id="submitted-data-output" class="space-y-3">
                        <!-- Data is inserted here by PHP -->
                        <?php foreach ($submitted_data as $key => $value): ?>
                            <?php 
                                // Get the friendly label from the defined form_fields array
                                $label = $form_fields[$key] ?? ucwords(str_replace('_', ' ', $key)); 
                            ?>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-1 p-2 border-b last:border-b-0">
                                <span class="font-medium text-gray-700 md:col-span-1"><?php echo $label; ?>:</span>
                                <span class="text-gray-900 md:col-span-2 break-words"><?php echo $value; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Button to reset the form (by redirecting to the same page without POST data) -->
                <button onclick="window.location.href='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>'"
                        class="mt-8 w-full bg-gray-500 text-white font-semibold py-3 px-4 rounded-lg hover:bg-gray-600 transition duration-200 shadow-md">
                    Register Another Applicant
                </button>
            </div>

        <?php endif; ?>

    </div>
</body>
</html>
