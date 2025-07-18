<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MOI Style Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .moi-card {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .moi-title {
            font-size: 24px;
            font-weight: bold;
            color: #004085;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="moi-card">
        <div class="moi-title">MOI Services Form</div>
        <form>
            <div class="mb-3">
                <label for="qatarId" class="form-label">Qatar ID</label>
                <input type="text" class="form-control" id="qatarId" placeholder="Enter your Qatar ID">
            </div>
            <div class="mb-3">
                <label for="serviceType" class="form-label">Service Type</label>
                <select class="form-select" id="serviceType">
                    <option selected>Select service</option>
                    <option value="1">Visa Inquiry</option>
                    <option value="2">Residency</option>
                    <option value="3">Traffic Violation</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</body>
</html>

