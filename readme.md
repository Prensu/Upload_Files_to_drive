# 📤 Upload Files to Google Drive (PHP + Google Drive API)

A simple PHP web application to upload **receipts, bills, or photos** from a web interface and securely store them in **Google Drive** using the **Google Drive API**.

This project is ideal for:
- Expense tracking systems
- Receipt/bill storage
- Document backup solutions
- Learning OAuth 2.0 with Google APIs

---

## 🚀 Features

- Upload files (images / receipts / bills) via web UI
- Secure Google OAuth 2.0 authentication
- Store uploaded files directly in **Google Drive**
- Save file references in MySQL database
- Clean and simple UI
- Uses Google Drive API (no third-party SDKs)

---

## 🧠 How It Works

1. User selects a file from the browser
2. File is temporarily stored on the server (`uploads/`)
3. User authorizes access via Google OAuth
4. File is uploaded to Google Drive
5. Google Drive file ID is stored in the database
6. A success message with Drive link is shown

---

## 📂 Project Structure

```text
google_drive_file_upload_php/
│
├── index.php                # Upload UI
├── upload.php               # Handles file upload
├── google_drive_sync.php    # OAuth callback + Drive upload
├── GoogleDriveApi.class.php # Google Drive API logic
├── config.php               # App & Google config
├── dbConfig.php             # Database connection
├── uploads/                 # Temporary uploaded files
├── css/
│   └── style.css            # UI styling
└── README.md
