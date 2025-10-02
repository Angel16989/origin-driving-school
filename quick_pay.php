<?php
// quick_pay.php - Quick Payment System (Dummy Payment Gateway)
session_start();
require_once 'php/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = '';
$error_msg = '';

// Get student ID
$stmt = $conn->prepare("SELECT s.id FROM students s JOIN users u ON u.username = s.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();

if (!$student) {
    $error_msg = "Student profile not found.";
    $student_id = 0;
} else {
    $student_id = $student['id'];
}

// Handle payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['make_payment']) && $student_id) {
    $invoice_id = intval($_POST['invoice_id']);
    $payment_method = $_POST['payment_method'];
    $card_number = $_POST['card_number'] ?? '';
    
    // Get invoice details
    $invoice_stmt = $conn->prepare("SELECT * FROM invoices WHERE id = ? AND student_id = ?");
    $invoice_stmt->bind_param("ii", $invoice_id, $student_id);
    $invoice_stmt->execute();
    $invoice = $invoice_stmt->get_result()->fetch_assoc();
    
    if ($invoice && $invoice['status'] === 'Unpaid') {
        // Simulate payment processing (dummy gateway)
        sleep(1); // Simulate processing time
        
        // Random success (90% success rate for demo)
        $payment_success = (rand(1, 100) <= 90);
        
        if ($payment_success) {
            // Update invoice status
            $update_invoice = $conn->prepare("UPDATE invoices SET status = 'Paid', paid_at = NOW() WHERE id = ?");
            $update_invoice->bind_param("i", $invoice_id);
            $update_invoice->execute();
            
            // Create payment record
            $insert_payment = $conn->prepare("INSERT INTO payments (invoice_id, amount, method, status, transaction_id, paid_at) VALUES (?, ?, ?, 'completed', ?, NOW())");
            $transaction_id = 'TXN' . strtoupper(uniqid());
            $insert_payment->bind_param("idss", $invoice_id, $invoice['amount'], $payment_method, $transaction_id);
            $insert_payment->execute();
            
            $success_msg = "✅ Payment successful! Transaction ID: $transaction_id";
        } else {
            $error_msg = "❌ Payment failed! Please try again or use a different payment method.";
        }
    } else {
        $error_msg = "❌ Invoice not found or already paid.";
    }
}

// Get unpaid invoices
$invoices_query = "SELECT * FROM invoices WHERE student_id = ? AND status = 'Unpaid' ORDER BY created_at DESC";
$invoices_stmt = $conn->prepare($invoices_query);
$invoices_stmt->bind_param("i", $student_id);
$invoices_stmt->execute();
$invoices = $invoices_stmt->get_result();

$page_title = "Quick Pay - Origin Driving School";
$page_description = "Quick and easy payment for your lessons";
include 'includes/header.php';
?>

<style>
    .payment-container {
        max-width: 1000px;
        margin: 6rem auto 2rem;
        padding: 2rem;
    }
    
    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin: 2rem 0;
    }
    
    .payment-method-card {
        border: 3px solid #e0e0e0;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .payment-method-card:hover {
        border-color: #0c2461;
        background: #f8f9fa;
    }
    
    .payment-method-card.selected {
        border-color: #0c2461;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    }
    
    .payment-method-icon {
        font-size: 3rem;
        margin-bottom: 0.5rem;
    }
    
    .invoice-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        border-left: 5px solid #ffc107;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .invoice-card:hover {
        transform: translateY(-5px);
    }
    
    .invoice-card.paid {
        border-left-color: #28a745;
        opacity: 0.7;
    }
    
    .card-input-group {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 1rem;
        margin: 1rem 0;
    }
    
    .payment-summary {
        background: linear-gradient(135deg, #fff8e1 0%, #ffe082 50%);
        padding: 2rem;
        border-radius: 15px;
        margin: 2rem 0;
    }
</style>

<div class="payment-container">
    <h1 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 1rem;">💳 Quick Pay</h1>
    <p style="text-align: center; color: #666; font-size: 1.1rem; margin-bottom: 3rem;">Fast and secure payment for your driving lessons</p>
    
    <?php if ($success_msg): ?>
        <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; border-left: 5px solid #28a745; text-align: center;">
            <h2 style="margin: 0 0 1rem 0;"><?php echo $success_msg; ?></h2>
            <div style="margin-top: 1.5rem;">
                <a href="php/my_invoices.php" class="btn btn-success">View All Invoices</a>
                <a href="dashboard.php" class="btn" style="margin-left: 1rem;">Back to Dashboard</a>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($error_msg): ?>
        <div style="background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%); color: #721c24; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; border-left: 5px solid #dc3545;">
            <strong><?php echo $error_msg; ?></strong>
        </div>
    <?php endif; ?>
    
    <?php if ($invoices->num_rows > 0): ?>
        <h2 style="color: var(--dashboard-blue); margin-bottom: 1.5rem;">📋 Unpaid Invoices</h2>
        
        <?php while ($invoice = $invoices->fetch_assoc()): ?>
            <div class="invoice-card">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                    <div>
                        <h3 style="margin: 0 0 0.5rem 0; color: var(--dashboard-blue);">Invoice #<?php echo $invoice['id']; ?></h3>
                        <p style="margin: 0; color: #666;">Created: <?php echo date('M j, Y', strtotime($invoice['created_at'])); ?></p>
                        <?php if ($invoice['due_date']): ?>
                            <p style="margin: 0.5rem 0 0 0; color: #dc3545; font-weight: 600;">
                                Due: <?php echo date('M j, Y', strtotime($invoice['due_date'])); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 2rem; font-weight: 700; color: var(--dashboard-blue);">
                            $<?php echo number_format($invoice['amount'], 2); ?>
                        </div>
                        <span style="background: #ffc107; color: white; padding: 0.3rem 1rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">Unpaid</span>
                    </div>
                </div>
                
                <!-- Payment Form -->
                <form method="POST" style="border-top: 2px dashed #e0e0e0; padding-top: 1.5rem;" onsubmit="return confirmPayment(<?php echo $invoice['amount']; ?>)">
                    <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                    
                    <h4 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Choose Payment Method:</h4>
                    
                    <div class="payment-methods">
                        <label class="payment-method-card">
                            <input type="radio" name="payment_method" value="Credit Card" required style="display: none;" onchange="selectPaymentMethod(this)">
                            <div class="payment-method-icon">💳</div>
                            <div style="font-weight: 600;">Credit Card</div>
                        </label>
                        
                        <label class="payment-method-card">
                            <input type="radio" name="payment_method" value="Debit Card" required style="display: none;" onchange="selectPaymentMethod(this)">
                            <div class="payment-method-icon">💳</div>
                            <div style="font-weight: 600;">Debit Card</div>
                        </label>
                        
                        <label class="payment-method-card">
                            <input type="radio" name="payment_method" value="PayPal" required style="display: none;" onchange="selectPaymentMethod(this)">
                            <div class="payment-method-icon">🅿️</div>
                            <div style="font-weight: 600;">PayPal</div>
                        </label>
                        
                        <label class="payment-method-card">
                            <input type="radio" name="payment_method" value="Bank Transfer" required style="display: none;" onchange="selectPaymentMethod(this)">
                            <div class="payment-method-icon">🏦</div>
                            <div style="font-weight: 600;">Bank</div>
                        </label>
                    </div>
                    
                    <div id="cardDetails" style="display: none; margin-top: 1.5rem;">
                        <h4 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Card Details:</h4>
                        <div class="card-input-group">
                            <input type="text" name="card_number" placeholder="Card Number (e.g., 4111 1111 1111 1111)" pattern="\d{4} \d{4} \d{4} \d{4}" style="padding: 0.8rem; border: 2px solid #e0e0e0; border-radius: 10px;">
                            <input type="text" placeholder="MM/YY" pattern="\d{2}/\d{2}" style="padding: 0.8rem; border: 2px solid #e0e0e0; border-radius: 10px;">
                            <input type="text" placeholder="CVV" pattern="\d{3}" maxlength="3" style="padding: 0.8rem; border: 2px solid #e0e0e0; border-radius: 10px;">
                        </div>
                        <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                            🔒 Your payment information is encrypted and secure
                        </p>
                    </div>
                    
                    <div class="payment-summary">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Subtotal:</span>
                            <span style="font-weight: 600;">$<?php echo number_format($invoice['amount'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Processing Fee:</span>
                            <span style="font-weight: 600;">$0.00</span>
                        </div>
                        <div style="border-top: 2px solid #333; margin: 1rem 0; padding-top: 1rem; display: flex; justify-content: space-between; font-size: 1.3rem;">
                            <strong>Total:</strong>
                            <strong style="color: var(--dashboard-blue);">$<?php echo number_format($invoice['amount'], 2); ?></strong>
                        </div>
                    </div>
                    
                    <button type="submit" name="make_payment" class="btn btn-success" style="width: 100%; font-size: 1.2rem; padding: 1rem;">
                        🔒 Pay $<?php echo number_format($invoice['amount'], 2); ?> Now
                    </button>
                </form>
            </div>
        <?php endwhile; ?>
        
    <?php else: ?>
        <div style="text-align: center; padding: 4rem; background: #f8f9fa; border-radius: 20px;">
            <div style="font-size: 5rem; margin-bottom: 1rem;">✅</div>
            <h2>All Caught Up!</h2>
            <p style="color: #666; font-size: 1.1rem;">You have no unpaid invoices at this time.</p>
            <div style="margin-top: 2rem;">
                <a href="dashboard.php" class="btn">Back to Dashboard</a>
                <a href="book_lesson.php" class="btn btn-success" style="margin-left: 1rem;">Book New Lesson</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function selectPaymentMethod(radio) {
        // Remove selected class from all cards
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selected class to clicked card
        radio.closest('.payment-method-card').classList.add('selected');
        
        // Show/hide card details based on method
        const method = radio.value;
        const cardDetails = document.getElementById('cardDetails');
        
        if (method === 'Credit Card' || method === 'Debit Card') {
            cardDetails.style.display = 'block';
            cardDetails.querySelectorAll('input').forEach(input => {
                input.required = true;
            });
        } else {
            cardDetails.style.display = 'none';
            cardDetails.querySelectorAll('input').forEach(input => {
                input.required = false;
            });
        }
    }
    
    function confirmPayment(amount) {
        return confirm(`Are you sure you want to pay $${amount.toFixed(2)}?\n\nThis is a DEMO payment system. No real charges will be made.`);
    }
</script>

<?php include 'includes/footer.php'; ?>
