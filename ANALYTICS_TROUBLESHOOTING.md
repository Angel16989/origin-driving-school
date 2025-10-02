# 🔧 Analytics Features Troubleshooting Guide

## If Reports Don't Download - Follow These Steps!

### Step 1: Test the Libraries
1. Go to: `http://localhost/Groupprojectdevelopingweb/php/analytics.php`
2. Click the **"🔧 Test Libraries"** button
3. Check the popup message:
   - ✅ ALL SYSTEMS READY = Everything is working
   - ❌ SOME LIBRARIES MISSING = Need to fix

### Step 2: Check Browser Console
1. Press `F12` on your keyboard
2. Click the "Console" tab
3. Look for errors in red
4. You should see:
   ```
   Chart.js loaded: true
   jsPDF loaded: true
   XLSX loaded: true
   ```

### Step 3: Check Internet Connection
The analytics page uses CDN libraries (from internet):
- Chart.js (for charts)
- jsPDF (for PDF reports)
- SheetJS (for Excel files)

**If offline or slow internet:**
- Libraries may not load
- Features won't work
- Refresh the page when connection is stable

### Step 4: Try Each Feature Individually

#### Test PDF Generation:
1. Click **"📊 Generate PDF Report"**
2. Wait for loading overlay (spinner)
3. PDF should auto-download
4. **If error:** Check console for error message

#### Test Excel Export:
1. Click **"📈 Export to Excel"**
2. Wait for loading overlay
3. Excel file should auto-download
4. **If error:** Check console for error message

#### Test Predictive Analytics:
1. Click **"🔮 Predictive Analytics"**
2. Popup should show forecasts
3. Works even offline (uses existing data)

#### Test Real-time Updates:
1. Click **"⚡ Enable Real-time Updates"**
2. Button turns green
3. Page refreshes every 30 seconds
4. Click again to disable

## Common Issues & Solutions

### Issue 1: "Library not loaded" Error
**Problem:** CDN libraries didn't download
**Solution:**
1. Check internet connection
2. Refresh the page (Ctrl+F5)
3. Wait 5-10 seconds for libraries to load
4. Try again

### Issue 2: Charts Not Showing
**Problem:** Chart.js didn't load
**Solution:**
1. Check console for errors
2. Refresh page
3. Make sure JavaScript is enabled in browser

### Issue 3: PDF/Excel Buttons Do Nothing
**Problem:** Functions not triggered or libraries missing
**Solution:**
1. Click "🔧 Test Libraries" first
2. Check console for errors
3. Try different browser (Chrome recommended)
4. Clear browser cache

### Issue 4: "Error generating PDF" Message
**Problem:** jsPDF library error
**Solution:**
1. Check if you have data (need some bookings/payments)
2. Try different date range
3. Check console for specific error
4. Refresh page and try again

### Issue 5: No Data in Charts
**Problem:** Database has no records for selected period
**Solution:**
1. Change date range to include all data
2. Add some test bookings/payments
3. Use setup scripts to add dummy data

## Browser Compatibility

### ✅ Recommended Browsers:
- **Chrome** (Latest) - BEST
- **Firefox** (Latest) - GOOD
- **Edge** (Latest) - GOOD
- Safari (Latest) - OK

### ❌ Not Supported:
- Internet Explorer (any version)
- Very old browsers

## Step-by-Step Testing Process

### Test 1: Page Loads
```
1. Open: http://localhost/Groupprojectdevelopingweb/php/analytics.php
2. ✅ Page loads without errors
3. ✅ You see 4 summary cards at top
4. ✅ You see 4 charts
5. ✅ You see filter bar
6. ✅ You see export buttons
```

### Test 2: Libraries Check
```
1. Click "🔧 Test Libraries"
2. ✅ Popup shows "ALL SYSTEMS READY"
3. If not, refresh page and wait 10 seconds
4. Try again
```

### Test 3: PDF Download
```
1. Click "📊 Generate PDF Report"
2. ✅ Loading spinner appears
3. ✅ After 1 second, spinner disappears
4. ✅ Success alert shows
5. ✅ PDF file downloads to your Downloads folder
6. ✅ Open PDF - should have tables and data
```

### Test 4: Excel Download
```
1. Click "📈 Export to Excel"
2. ✅ Loading spinner appears
3. ✅ After 1 second, spinner disappears
4. ✅ Success alert shows
5. ✅ Excel file downloads
6. ✅ Open Excel - should have 4 sheets with data
```

### Test 5: Charts Working
```
1. Look at the 4 charts on page
2. ✅ Revenue chart shows line graph
3. ✅ Bookings chart shows bar graph
4. ✅ Instructor chart shows horizontal bars
5. ✅ Enrollment chart shows line graph
6. Hover over charts to see tooltips
```

## Advanced Troubleshooting

### Check Network Tab (F12 → Network):
Look for these files:
- ✅ `chart.umd.min.js` (200 OK)
- ✅ `jspdf.umd.min.js` (200 OK)
- ✅ `jspdf.plugin.autotable.min.js` (200 OK)
- ✅ `xlsx.full.min.js` (200 OK)

If any show errors (404, etc.):
- Internet connection issue
- CDN might be down
- Use different internet connection

### Check Console Logs:
You should see:
```
Chart.js loaded: true
jsPDF loaded: true
XLSX loaded: true
Data loaded: {revenue: 10, bookings: 15, instructors: 3, enrollment: 5}
DOM loaded, initializing charts...
```

### If You See Errors:
**"Chart is not defined"**
- Chart.js didn't load
- Refresh page

**"jspdf is not defined"**
- jsPDF didn't load
- Check internet
- Refresh page

**"XLSX is not defined"**
- SheetJS didn't load
- Check internet
- Refresh page

## Manual Testing Commands

Open Console (F12) and type:

### Test Chart.js:
```javascript
typeof Chart
// Should return: "function"
```

### Test jsPDF:
```javascript
typeof window.jspdf
// Should return: "object"
```

### Test XLSX:
```javascript
typeof XLSX
// Should return: "object"
```

### Test Data:
```javascript
console.log(revenueData);
console.log(bookingData);
console.log(instructorData);
console.log(enrollmentData);
// Should show arrays with data
```

## Quick Fix Checklist

If nothing works, do this in order:

1. ☐ Check internet connection
2. ☐ Refresh page (Ctrl+F5)
3. ☐ Wait 10 seconds for libraries to load
4. ☐ Click "🔧 Test Libraries" button
5. ☐ Check browser console (F12 → Console)
6. ☐ Try in Chrome browser
7. ☐ Clear browser cache
8. ☐ Close and reopen browser
9. ☐ Restart XAMPP
10. ☐ Check if you have data in database

## Contact Debug Info

If you need help, provide this info:

1. **Browser:** (Chrome/Firefox/Edge?)
2. **Test Libraries Result:** (What does it say?)
3. **Console Errors:** (Copy any red errors)
4. **Which button doesn't work:** (PDF/Excel/Charts?)
5. **Data status:** (Do you have bookings/payments?)

## Expected File Downloads

### PDF File:
- **Name:** `analytics-report-1696234567890.pdf`
- **Size:** ~50-200 KB
- **Location:** Downloads folder
- **Contains:** 
  - School header
  - Summary statistics table
  - Instructor performance table
  - Page numbers and footer

### Excel File:
- **Name:** `analytics-data-1696234567890.xlsx`
- **Size:** ~10-50 KB
- **Location:** Downloads folder
- **Contains 4 Sheets:**
  1. Summary (header + metrics)
  2. Revenue (daily revenue data)
  3. Bookings (booking trends)
  4. Instructors (performance data)

## Still Not Working?

### Last Resort Fixes:

1. **Use different browser:**
   - Try Chrome if using Firefox
   - Try Edge if using Chrome

2. **Check popup blockers:**
   - Some browsers block downloads
   - Allow downloads from localhost

3. **Check download settings:**
   - Browser might be blocking automatic downloads
   - Check browser settings

4. **Try incognito mode:**
   - Opens browser without cache/extensions
   - Tests if extensions are interfering

5. **Restart everything:**
   - Close browser completely
   - Stop XAMPP
   - Start XAMPP
   - Open browser
   - Try again

## Success Indicators

You'll know it's working when:
- ✅ "🔧 Test Libraries" shows "ALL SYSTEMS READY"
- ✅ Charts display with colored lines/bars
- ✅ PDF downloads and opens with data
- ✅ Excel downloads and has 4 sheets
- ✅ No errors in console
- ✅ Loading spinner appears and disappears
- ✅ Success alert messages show

---
**Everything is now working with proper error handling and debugging tools!**
*Last updated: October 2, 2025*
