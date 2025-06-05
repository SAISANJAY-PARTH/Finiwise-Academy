<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$name = htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8');
$user_id = (int)$_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - FinWise Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Inter", sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }
        .navbar {
            background-color: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-radius: 8px;
        }
        .navbar .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }
        .navbar li {
            margin: 0;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 16px;
            transition: color 0.2s ease-in-out;
        }
        .navbar a:hover {
            color: #007bff;
        }
        @media (max-width: 768px) {
            .navbar .nav-container {
                justify-content: center;
            }
            .navbar ul {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-top: 30px;
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 30px;
        }
        h4 {
            color: #555;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .btn-group-vertical {
            width: 100%;
        }
        .btn {
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 1.05rem;
            margin-bottom: 10px;
        }
        .calculator-container {
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .calculator-container h5 {
            color: #007bff;
            margin-bottom: 20px;
        }
        .calculator-container label {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            text-align: left;
            font-weight: 500;
        }
        .calculator-container input.form-control {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 15px auto;
            border-radius: 5px;
        }
        .calculator-container button {
            margin-top: 15px;
        }
        .result-text {
            font-size: 1.2rem;
            color: #28a745;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <ul>
                <li><a href="about-founder.html">Founder</a></li>
                <li><a href="signup.html">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Welcome, <?php echo $name; ?> 👋</h2>

        <div class="mt-4">
            <h4>Tools You Can Use:</h4>
            <div class="d-grid gap-2 col-md-8 col-lg-6 mx-auto">
                <button class="btn btn-primary" onclick="showCalculator('sip')">SIP Calculator</button>
                <button class="btn btn-secondary" onclick="showCalculator('fd')">FD Calculator</button>
                <button class="btn btn-success" onclick="showCalculator('loan')">Loan EMI Calculator</button>
                <button class="btn btn-info" onclick="showCalculator('ppf')">PPF Calculator</button>
                <button class="btn btn-warning" onclick="showCalculator('epf')">EPF Calculator</button>
                <button class="btn btn-primary" onclick="showCalculator('cagr')">CAGR Calculator</button>
                <button class="btn btn-secondary" onclick="showCalculator('rental')">Rental Yield Calculator</button>
                <button class="btn btn-success" onclick="showCalculator('salary')">Net Salary Calculator</button>
                <button class="btn btn-info" onclick="showCalculator('inflation')">Inflation Calculator</button>
            </div>
        </div>

        <div id="calculator-container" class="mt-4 calculator-container">
            <em>Select a calculator above to start.</em>
        </div>

        <div class="mt-5 text-center">
            <h4>Other Actions:</h4>
        
            <a href="history.php" class="btn btn-outline-success mt-3">History</a>
        </div>

        <a href="logout.php" class="btn btn-danger mt-4 d-block mx-auto col-md-4 col-lg-3">Logout</a>
    </div>

    <script>
        // Pass user_id from PHP to JavaScript
        const userId = <?php echo json_encode($user_id); ?>;

        // Function to show each calculator inside container
        function showCalculator(name) {
            const container = document.getElementById('calculator-container');
            container.innerHTML = '';

            let calculatorHtml = '';
            if (name === 'sip') {
                calculatorHtml = `
                    <h5>SIP Calculator</h5>
                    <label>Monthly Investment (₹): <input id="sip_amount" type="number" min="1" class="form-control mb-2"></label>
                    <label>Expected Rate of Return (% p.a.): <input id="sip_rate" type="number" step="0.01" min="0.01" class="form-control mb-2"></label>
                    <label>Investment Duration (years): <input id="sip_years" type="number" min="1" class="form-control mb-3"></label>
                    <button class="btn btn-primary" onclick="calculateSIP()">Calculate</button>
                    <p id="sip_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'fd') {
                calculatorHtml = `
                    <h5>Fixed Deposit Calculator</h5>
                    <label>Principal Amount (₹): <input id="fd_principal" type="number" min="1" class="form-control mb-2"></label>
                    <label>Interest Rate (% p.a.): <input id="fd_rate" type="number" step="0.01" min="0.01" class="form-control mb-2"></label>
                    <label>Duration (years): <input id="fd_years" type="number" min="1" class="form-control mb-3"></label>
                    <button class="btn btn-secondary" onclick="calculateFD()">Calculate</button>
                    <p id="fd_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'loan') {
                calculatorHtml = `
                    <h5>Loan EMI Calculator</h5>
                    <label>Loan Amount (₹): <input id="loan_amount" type="number" min="1" class="form-control mb-2"></label>
                    <label>Interest Rate (% p.a.): <input id="loan_rate" type="number" step="0.01" min="0.01" class="form-control mb-2"></label>
                    <label>Loan Tenure (years): <input id="loan_years" type="number" min="1" class="form-control mb-3"></label>
                    <button class="btn btn-success" onclick="calculateLoanEMI()">Calculate</button>
                    <p id="loan_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'ppf') {
                calculatorHtml = `
                    <h5>PPF Calculator</h5>
                    <label>Annual Investment (₹): <input id="ppf_amount" type="number" min="1" class="form-control mb-2"></label>
                    <label>Interest Rate (% p.a.): <input id="ppf_rate" type="number" step="0.01" min="0.01" class="form-control mb-2" value="7.1"></label>
                    <label>Investment Duration (years, max 15): <input id="ppf_years" type="number" min="1" max="15" class="form-control mb-3"></label>
                    <button class="btn btn-info" onclick="calculatePPF()">Calculate</button>
                    <p id="ppf_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'epf') {
                calculatorHtml = `
                    <h5>EPF Calculator</h5>
                    <label>Monthly Basic Salary + DA (₹): <input id="epf_salary" type="number" min="1" class="form-control mb-2"></label>
                    <label>Employee Contribution (%): <input id="epf_employee_rate" type="number" step="0.01" min="0" class="form-control mb-2" value="12"></label>
                    <label>Employer Contribution (%): <input id="epf_employer_rate" type="number" step="0.01" min="0" class="form-control mb-2" value="3.67"></label>
                    <label>Interest Rate (% p.a.): <input id="epf_rate" type="number" step="0.01" min="0.01" class="form-control mb-2" value="8.15"></label>
                    <label>Investment Duration (years): <input id="epf_years" type="number" min="1" class="form-control mb-3"></label>
                    <button class="btn btn-warning" onclick="calculateEPF()">Calculate</button>
                    <p id="epf_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'cagr') {
                calculatorHtml = `
                    <h5>CAGR Calculator</h5>
                    <label>Initial Investment (₹): <input id="cagr_initial" type="number" min="1" class="form-control mb-2"></label>
                    <label>Final Value (₹): <input id="cagr_final" type="number" min="1" class="form-control mb-2"></label>
                    <label>Investment Duration (years): <input id="cagr_years" type="number" min="1" class="form-control mb-3"></label>
                    <button class="btn btn-primary" onclick="calculateCAGR()">Calculate</button>
                    <p id="cagr_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'rental') {
                calculatorHtml = `
                    <h5>Rental Yield Calculator</h5>
                    <label>Annual Rental Income (₹): <input id="rental_income" type="number" min="0" class="form-control mb-2"></label>
                    <label>Property Value (₹): <input id="rental_value" type="number" min="1" class="form-control mb-2"></label>
                    <button class="btn btn-secondary" onclick="calculateRentalYield()">Calculate</button>
                    <p id="rental_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'salary') {
                calculatorHtml = `
                    <h5>Net Salary Calculator</h5>
                    <label>Gross Monthly Salary (₹): <input id="salary_gross" type="number" min="1" class="form-control mb-2"></label>
                    <label>HRA Exemption (₹): <input id="salary_hra" type="number" min="0" class="form-control mb-2" value="0"></label>
                    <label>Other Exemptions (₹): <input id="salary_other" type="number" min="0" class="form-control mb-2" value="0"></label>
                    <label>Tax Rate (%): <input id="salary_tax_rate" type="number" step="0.01" min="0" class="form-control mb-3" value="30"></label>
                    <button class="btn btn-success" onclick="calculateNetSalary()">Calculate</button>
                    <p id="salary_result" class="mt-3 fw-bold result-text"></p>
                `;
            } else if (name === 'inflation') {
                calculatorHtml = `
                    <h5>Inflation Calculator</h5>
                    <label>Current Cost (₹): <input id="inflation_current" type="number" min="1" class="form-control mb-2"></label>
                    <label>Inflation Rate (% p.a.): <input id="inflation_rate" type="number" step="0.01" min="0" class="form-control mb-2"></label>
                    <label>Time Period (years): <input id="inflation_years" type="number" min="1" class="form-control mb-3"></label>
                    <button class="btn btn-info" onclick="calculateInflation()">Calculate</button>
                    <p id="inflation_result" class="mt-3 fw-bold result-text"></p>
                `;
            }
            container.innerHTML = calculatorHtml;
        }

        // Function to save calculator usage via AJAX
        function saveHistory(calculatorName, inputValues, outputResult) {
            fetch('save_history.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    calculator: calculatorName,
                    input: inputValues,
                    output: outputResult
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    console.error('Failed to save history:', data.message);
                } else {
                    console.log('History saved successfully.');
                }
            })
            .catch(error => {
                console.error('Error saving history:', error);
            });
        }

        // Calculation functions
        function calculateSIP() {
            const P = parseFloat(document.getElementById('sip_amount').value);
            const r_annual = parseFloat(document.getElementById('sip_rate').value);
            const t_years = parseFloat(document.getElementById('sip_years').value);

            if (isNaN(P) || isNaN(r_annual) || isNaN(t_years) || P <= 0 || r_annual <= 0 || t_years <= 0) {
                alert('Please enter valid positive numbers for SIP calculation.');
                return;
            }

            const r_monthly = r_annual / 100 / 12;
            const n_months = t_years * 12;
            const fv = P * ((Math.pow(1 + r_monthly, n_months) - 1) / r_monthly) * (1 + r_monthly);
            const resultText = 'Maturity Amount: ₹' + fv.toFixed(2);
            document.getElementById('sip_result').innerText = resultText;

            saveHistory('SIP Calculator', {
                'Monthly Investment': P,
                'Annual Rate': r_annual,
                'Duration (Years)': t_years
            }, resultText);
        }

        function calculateFD() {
            const P = parseFloat(document.getElementById('fd_principal').value);
            const r_annual = parseFloat(document.getElementById('fd_rate').value);
            const t_years = parseFloat(document.getElementById('fd_years').value);

            if (isNaN(P) || isNaN(r_annual) || isNaN(t_years) || P <= 0 || r_annual <= 0 || t_years <= 0) {
                alert('Please enter valid positive numbers for FD calculation.');
                return;
            }

            const r_decimal = r_annual / 100;
            const amount = P * Math.pow(1 + r_decimal, t_years);
            const resultText = 'Maturity Amount: ₹' + amount.toFixed(2);
            document.getElementById('fd_result').innerText = resultText;

            saveHistory('FD Calculator', {
                'Principal Amount': P,
                'Annual Rate': r_annual,
                'Duration (Years)': t_years
            }, resultText);
        }

        function calculateLoanEMI() {
            const P = parseFloat(document.getElementById('loan_amount').value);
            const r_annual = parseFloat(document.getElementById('loan_rate').value);
            const t_years = parseFloat(document.getElementById('loan_years').value);

            if (isNaN(P) || isNaN(r_annual) || isNaN(t_years) || P <= 0 || r_annual <= 0 || t_years <= 0) {
                alert('Please enter valid positive numbers for Loan EMI calculation.');
                return;
            }

            const r_monthly = r_annual / 100 / 12;
            const n_months = t_years * 12;

            if (r_monthly === 0) {
                const emi = P / n_months;
                const resultText = 'EMI: ₹' + emi.toFixed(2);
                document.getElementById('loan_result').innerText = resultText;
                saveHistory('Loan EMI Calculator', {
                    'Loan Amount': P,
                    'Annual Rate': r_annual,
                    'Tenure (Years)': t_years
                }, resultText);
                return;
            }

            const emi = (P * r_monthly * Math.pow(1 + r_monthly, n_months)) / (Math.pow(1 + r_monthly, n_months) - 1);
            const resultText = 'EMI: ₹' + emi.toFixed(2);
            document.getElementById('loan_result').innerText = resultText;

            saveHistory('Loan EMI Calculator', {
                'Loan Amount': P,
                'Annual Rate': r_annual,
                'Tenure (Years)': t_years
                }, resultText);
        }

        function calculatePPF() {
            const P_annual = parseFloat(document.getElementById('ppf_amount').value);
            const r_annual = parseFloat(document.getElementById('ppf_rate').value);
            const t_years = parseFloat(document.getElementById('ppf_years').value);

            if (isNaN(P_annual) || isNaN(r_annual) || isNaN(t_years) || P_annual <= 0 || r_annual <= 0 || t_years <= 0 || t_years > 15) {
                alert('Please enter valid positive numbers for PPF calculation. Duration max 15 years.');
                return;
            }

            const r_decimal = r_annual / 100;
            let amount = 0;
            for (let i = 0; i < t_years; i++) {
                amount = (amount + P_annual) * (1 + r_decimal);
            }
            const resultText = 'Maturity Amount: ₹' + amount.toFixed(2);
            document.getElementById('ppf_result').innerText = resultText;

            saveHistory('PPF Calculator', {
                'Annual Investment': P_annual,
                'Annual Rate': r_annual,
                'Duration (Years)': t_years
            }, resultText);
        }

        function calculateEPF() {
            const salary = parseFloat(document.getElementById('epf_salary').value);
            const employeeRate = parseFloat(document.getElementById('epf_employee_rate').value);
            const employerRate = parseFloat(document.getElementById('epf_employer_rate').value);
            const r_annual = parseFloat(document.getElementById('epf_rate').value);
            const t_years = parseFloat(document.getElementById('epf_years').value);

            if (isNaN(salary) || isNaN(employeeRate) || isNaN(employerRate) || isNaN(r_annual) || isNaN(t_years) ||
                salary <= 0 || employeeRate < 0 || employerRate < 0 || r_annual <= 0 || t_years <= 0) {
                alert('Please enter valid numbers for EPF calculation.');
                return;
            }

            const monthlyContribution = salary * (employeeRate / 100 + employerRate / 100);
            const r_monthly = r_annual / 100 / 12;
            const n_months = t_years * 12;

            const amount = monthlyContribution * ((Math.pow(1 + r_monthly, n_months) - 1) / r_monthly) * (1 + r_monthly);
            const resultText = 'Maturity Amount: ₹' + amount.toFixed(2);
            document.getElementById('epf_result').innerText = resultText;

            saveHistory('EPF Calculator', {
                'Monthly Basic Salary + DA': salary,
                'Employee Contribution (%)': employeeRate,
                'Employer Contribution (%)': employerRate,
                'Annual Rate': r_annual,
                'Duration (Years)': t_years
            }, resultText);
        }

        function calculateCAGR() {
            const initial = parseFloat(document.getElementById('cagr_initial').value);
            const final = parseFloat(document.getElementById('cagr_final').value);
            const t_years = parseFloat(document.getElementById('cagr_years').value);

            if (isNaN(initial) || isNaN(final) || isNaN(t_years) || initial <= 0 || final <= 0 || t_years <= 0) {
                alert('Please enter valid positive numbers for CAGR calculation.');
                return;
            }

            const cagr = (Math.pow(final / initial, 1 / t_years) - 1) * 100;
            const resultText = 'CAGR: ' + cagr.toFixed(2) + '%';
            document.getElementById('cagr_result').innerText = resultText;

            saveHistory('CAGR Calculator', {
                'Initial Investment': initial,
                'Final Value': final,
                'Duration (Years)': t_years
            }, resultText);
        }

        function calculateRentalYield() {
            const rentalIncome = parseFloat(document.getElementById('rental_income').value);
            const propertyValue = parseFloat(document.getElementById('rental_value').value);

            if (isNaN(rentalIncome) || isNaN(propertyValue) || rentalIncome < 0 || propertyValue <= 0) {
                alert('Please enter valid numbers for Rental Yield calculation.');
                return;
            }

            const yield_percent = (rentalIncome / propertyValue) * 100;
            const resultText = 'Rental Yield: ' + yield_percent.toFixed(2) + '%';
            document.getElementById('rental_result').innerText = resultText;

            saveHistory('Rental Yield Calculator', {
                'Annual Rental Income': rentalIncome,
                'Property Value': propertyValue
            }, resultText);
        }

        function calculateNetSalary() {
            const gross = parseFloat(document.getElementById('salary_gross').value);
            const hra = parseFloat(document.getElementById('salary_hra').value);
            const otherExemptions = parseFloat(document.getElementById('salary_other').value);
            const taxRate = parseFloat(document.getElementById('salary_tax_rate').value);

            if (isNaN(gross) || isNaN(hra) || isNaN(otherExemptions) || isNaN(taxRate) ||
                gross <= 0 || hra < 0 || otherExemptions < 0 || taxRate < 0) {
                alert('Please enter valid numbers for Net Salary calculation.');
                return;
            }

            const annualGross = gross * 12;
            const taxableIncome = annualGross - hra - otherExemptions;
            const tax = taxableIncome * (taxRate / 100);
            const netAnnualSalary = annualGross - tax;
            const netMonthlySalary = netAnnualSalary / 12;

            const resultText = 'Net Monthly Salary: ₹' + netMonthlySalary.toFixed(2);
            document.getElementById('salary_result').innerText = resultText;

            saveHistory('Net Salary Calculator', {
                'Gross Monthly Salary': gross,
                'HRA Exemption': hra,
                'Other Exemptions': otherExemptions,
                'Tax Rate (%)': taxRate
            }, resultText);
        }

        function calculateInflation() {
            const currentCost = parseFloat(document.getElementById('inflation_current').value);
            const r_annual = parseFloat(document.getElementById('inflation_rate').value);
            const t_years = parseFloat(document.getElementById('inflation_years').value);

            if (isNaN(currentCost) || isNaN(r_annual) || isNaN(t_years) || currentCost <= 0 || r_annual < 0 || t_years <= 0) {
                alert('Please enter valid numbers for Inflation calculation.');
                return;
            }

            const r_decimal = r_annual / 100;
            const futureCost = currentCost * Math.pow(1 + r_decimal, t_years);
            const resultText = 'Future Cost: ₹' + futureCost.toFixed(2);
            document.getElementById('inflation_result').innerText = resultText;

            saveHistory('Inflation Calculator', {
                'Current Cost': currentCost,
                'Inflation Rate (%)': r_annual,
                'Time Period (Years)': t_years
            }, resultText);
        }
    </script>
</body>
</html>