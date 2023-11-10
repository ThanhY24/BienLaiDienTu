<div id="receiptPrintBody" style="width: 80mm; height:auto">
    <div
        id="receipt-print-body"
        style="border: 1px solid; font-family: Arial, Helvetica, sans-serif"
    >
            <p
                style="
                    margin: 0;
                    padding: 0;
                    text-align: center;
                    font-weight: 600;
                    margin-top: 10px;
                "
                id="receipt-name"
            >
                {{$dataArrayResponse['Content']['ComName']}}
            </p>
            <p
                style="
                    margin: 0;
                    padding: 0;
                    text-align: center;
                    margin-top: 3px;
                "
            >
                ----------------***----------------
            </p>
            <p
                style="
                    margin: 0;
                    padding: 0;
                    text-align: center;
                    font-size: 15px;
                "
                id="receipt-taxID"
            >
                {{$dataArrayResponse['Content']['ComTaxCode']}}
            </p>
            <p
                style="
                    margin: 0;
                    padding: 0;
                    text-align: center;
                    margin-top: 5px;
                    font-weight: 600;
                    padding: 0 10px;
                    box-sizing: border-box;
                "
            >
                BIÊN NHẬN THU THUẾ, PHÍ, LỆ PHÍ
            </p>
            <p
                style="
                    margin: 0;
                    padding: 0 10px;
                    text-align: center;
                    font-size: 15px;
                "
                id="receipt-fee-name"
            >
                Tên phí, lệ phí: {{$dataArrayResponse['Content']['Extra']}}
            </p>
            <p
                style="margin: 0; padding: 0 10px; font-size: 15px"
                id="receipt-cus-name"
            >
                Tên khách hàng: {{$dataArrayResponse['Content']['CusName']}}
            </p>
            <p
                style="margin: 0; padding: 0 10px; font-size: 15px"
                id="receipt-cus-taxID"
            >
                Mã số thuế: 
            </p>
            <p
                style="margin: 0; padding: 0 10px; font-size: 15px"
                id="receipt-cus-address"
            >
                Địa chỉ:
            </p>
            <p
                style="margin: 0; padding: 0 10px; font-size: 15px"
                id="receipt-amount"
            >
                Số tiền: {{$dataArrayResponse['Content']['Total']}}
            </p>
            <p
                style="margin: 0; padding: 0 10px; font-size: 15px"
                id="receipt-amount-in-word"
            >
                (Viết bằng chữ): {{$dataArrayResponse['Content']['AmountInWords']}}
            </p>
            <p
                style="margin: 0; padding: 0 10px; font-size: 15px"
                id="receipt-payment-method"
            >
                Hình thức thanh toán: {{$dataArrayResponse['Content']['Kind_of_Payment']}}
            </p>
            <div style="margin-top: 5px; margin-bottom:10px; padding: 0 10px">
                <div
                    style="
                        display: flex;
                        flex-dicrection: row;
                        justify-content: space-between;
                    "
                >
                    <p
                        id="receipt-qrcode"
                        style="margin: 0px; width: 50px; height: 50px"
                    ></p>
                    <p
                        style="margin: 0; font-size: 13px"
                        id="receipt-pattern-serial"
                    >Mẫu số: {{$dataArrayResponse['Content']['InvoicePattern']}}</br>Ký hiệu: {{$dataArrayResponse['Content']['SerialNo']}}</p>
                </div>
            </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script>
    // Lấy thẻ chứa QR code
    var qrcodeContainer = document.getElementById("receipt-qrcode");
    // Xóa nội dung cũ của thẻ (nếu có)
    qrcodeContainer.innerHTML = "";
    // Tạo QR code mới và thêm vào thẻ
    var Fkey = <?php echo json_encode($fkey_receipt); ?>;
    var qrcode = new QRCode(qrcodeContainer, {
                    text: Fkey,
                    width: 50,
                    height: 50
                });
    function saveDivAsImageAndCloseTab(divId, fileName) {
        const div = document.getElementById(divId);
        html2canvas(div).then(function (canvas) {
        const imgData = canvas.toDataURL("image/png");
        const a = document.createElement("a");
        a.href = imgData;
        a.download = fileName;
        a.click();
        });
    }
    saveDivAsImageAndCloseTab("receiptPrintBody", "receipt.png");
</script>
