# 📬 Admin Inbox & Email System Documentation
## Origin Driving School - Contact Management System

**Created:** October 5, 2025  
**Purpose:** Centralized inbox for all contact form submissions with reply functionality

---

## 🌟 **System Overview**

The Admin Inbox system captures all contact form submissions (from logged-in and non-logged-in users) and provides admins with a powerful interface to:
- ✅ View all messages in one place
- ✅ Mark messages as read
- ✅ Reply to users via email
- ✅ Track conversation history
- ✅ Close completed inquiries
- ✅ Filter and search messages

---

## 📊 **How It Works**

### **1. Contact Form Submission (Any User)**

**Location:** `contact.php`

When someone (logged in or not) submits the contact form:

```
User fills form → process_contact.php → Saved to contact_messages table
```

**Data Captured:**
- Name
- Email
- Phone (optional)
- Subject
- Message
- Newsletter subscription preference
- Timestamp
- Status (default: "new")

---

### **2. Admin Inbox Panel**

**Access:** Admin Navigation → **📬 Inbox**  
**File:** `php/admin_inbox.php`

#### **Features:**

**A. Statistics Dashboard**
- 📊 Total Messages
- 🆕 New (unread)
- 👀 Read
- ✅ Replied
- 🔒 Closed

Click any stat card to filter messages by that status!

**B. Search Functionality**
Search across:
- Sender name
- Email address
- Subject
- Message content

**C. Message List**
Each message shows:
- Sender name and email
- Subject line
- Message preview (first 200 characters)
- Phone number (if provided)
- Newsletter subscription indicator 📧
- Timestamp
- Status badge
- Action buttons (View, Reply, Close)

**D. Visual Indicators**
- 🔵 Blue highlight = New/unread message
- Color-coded status badges
- Hover effects for better UX

---

### **3. Message Actions**

#### **A. View Message**
Click any message to open full details:
- ✅ Automatically marks as "read"
- Shows complete message
- Displays contact information with clickable links
- Shows previous replies (conversation history)
- Provides reply form

#### **B. Reply to Message**
1. Click "✉️ Reply" button
2. Type your response in the text area
3. Click "📤 Send Reply"

**What Happens:**
```
Reply sent → Saved to message_replies table
           → Message status updated to "replied"
           → Email sent to customer (HTML formatted)
           → Email saved to temp_emails/ folder (for development)
           → Security log created
```

**Email Template Includes:**
- Professional Origin Driving School branding
- Your reply text
- Original customer message (for context)
- Contact information
- Unsubscribe links (in footer)

#### **C. Close Message**
- Marks inquiry as resolved
- Status changed to "closed"
- Message archived but still searchable

---

## 📁 **Database Structure**

### **Table 1: `contact_messages`**

```sql
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    newsletter_signup BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new'
);
```

### **Table 2: `message_replies`**

```sql
CREATE TABLE message_replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_id INT NOT NULL,
    admin_id INT NOT NULL,
    reply_text TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (message_id) REFERENCES contact_messages(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### **Table 3: `newsletter_subscribers`**

```sql
CREATE TABLE newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255),
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'unsubscribed') DEFAULT 'active'
);
```

---

## 🎨 **User Interface Features**

### **Modern Design Elements**
- ✨ Gradient backgrounds
- 🎯 Color-coded status badges
- 📱 Responsive layout
- 🖱️ Hover animations
- 🎭 Modal popups
- 🔍 Live filtering

### **Status Colors**
- 🔵 **New** - Blue (#2196f3)
- 🟠 **Read** - Orange (#ff9800)
- 🟢 **Replied** - Green (#4caf50)
- ⚫ **Closed** - Gray (#9e9e9e)

---

## 🔒 **Security Features**

✅ **Admin-only access** - Session validation  
✅ **CSRF protection** - On contact forms  
✅ **Rate limiting** - Max 3 submissions per 10 minutes  
✅ **Input sanitization** - All user inputs cleaned  
✅ **SQL injection prevention** - Prepared statements  
✅ **XSS protection** - HTML escaping  
✅ **Security logging** - All actions tracked  

---

## 📧 **Email System**

### **Current Implementation (Development)**
- Emails are generated with HTML templates
- Saved to `temp_emails/` folder as `.html` files
- Includes full branding and styling
- Format: `YYYY-MM-DD_HH-MM-SS_MessageID.html`

### **Production Setup (Future)**
To enable real email sending, integrate PHPMailer:

```php
// In inbox_actions.php, replace mock email with:
require 'vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->setFrom('noreply@origindrivingschool.com', 'Origin Driving School');
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = $emailBody;

return $mail->send();
```

---

## 🔄 **Workflow Example**

### **Scenario: New Student Inquiry**

1. **Visitor submits form** (contact.php)
   - Name: "John Smith"
   - Email: "john@example.com"
   - Subject: "Lesson Inquiry"
   - Message: "I'd like to book driving lessons"

2. **Form processed** (process_contact.php)
   - ✅ Saved to database
   - ✅ Status: "new"
   - ✅ Security logged

3. **Admin receives notification**
   - 🆕 New count increases
   - Message appears at top of inbox
   - Blue highlight indicates unread

4. **Admin views message**
   - Opens full details modal
   - Status auto-changes to "read"
   - 👀 Read count updates

5. **Admin replies**
   - Types: "Thanks for your interest! We offer flexible scheduling..."
   - Clicks "Send Reply"
   - ✅ Reply saved to database
   - ✅ Email sent to john@example.com
   - ✅ Status changed to "replied"

6. **Follow-up**
   - If more questions → reply again (conversation thread)
   - When resolved → click "Close" (archived)

---

## 📝 **Files Created**

| File | Purpose | Location |
|------|---------|----------|
| `admin_inbox.php` | Main inbox interface | `/php/` |
| `inbox_actions.php` | Backend actions (view/reply/close) | `/php/` |
| `process_contact.php` | Contact form processor | `/` (root) |
| `contact_messages` | Database table | MySQL |
| `message_replies` | Reply history table | MySQL |
| `newsletter_subscribers` | Newsletter list | MySQL |

---

## 🚀 **How to Access**

### **For Admins:**
1. Login as admin
2. Look for **📬 Inbox** in navigation bar
3. Click to access inbox panel

### **For Users:**
1. Visit **Contact** page
2. Fill out form (no login required!)
3. Submit → Message goes to Admin Inbox

---

## ✨ **Key Benefits**

✅ **Centralized Communication** - All inquiries in one place  
✅ **No Emails Lost** - Database backup of all messages  
✅ **Conversation History** - Track entire communication thread  
✅ **Quick Responses** - Reply directly from dashboard  
✅ **Professional Image** - Branded email templates  
✅ **Status Tracking** - Know what's been handled  
✅ **Search & Filter** - Find messages instantly  
✅ **Newsletter Integration** - Auto-subscribe interested users  

---

## 🎯 **Future Enhancements**

### **Phase 2 (Optional)**
- 📱 Email notifications for new messages
- 🔔 Browser push notifications
- 📊 Response time analytics
- 🤖 Auto-reply templates
- 📎 File attachments support
- 🏷️ Message tagging/categorization
- 📅 Follow-up reminders
- 👥 Assign messages to specific admins
- 📈 Satisfaction surveys after resolution

---

## 🛠️ **Testing Checklist**

- [ ] Submit contact form (not logged in)
- [ ] Check message appears in Admin Inbox
- [ ] Verify status changes (new → read)
- [ ] Send reply from admin panel
- [ ] Check email saved to temp_emails/
- [ ] Verify reply appears in conversation thread
- [ ] Test search functionality
- [ ] Test status filters
- [ ] Test close message function
- [ ] Verify security logs created

---

## 📞 **Support**

For questions about this system:
- Review code comments in `admin_inbox.php`
- Check `inbox_actions.php` for backend logic
- View `process_contact.php` for form handling
- Test in development before production

---

**System Status:** ✅ Fully Functional  
**Ready for:** Development Testing  
**Next Step:** Test all features, then deploy!

---

**Created by:** Origin Driving School Development Team  
**For:** DWIN309 Final Assessment  
**Date:** October 5, 2025
