import React, { useState } from 'react';

const Payment = () => {
  const [showPaymentForm, setShowPaymentForm] = useState(false);

  const handlePayWithUPI = (upiPaymentUrl) => {
    window.location.href = upiPaymentUrl;
  };

  const handlePayWithUPIForm = () => {
    setShowPaymentForm(true);
  };

  const handleSubmitPayment = (event) => {
    event.preventDefault();
    const upiId = event.target.elements.upiId.value;
    if (!upiId) {
      alert('Please enter a valid UPI ID.');
      return;
    }
    setShowPaymentForm(false);
    // Simulate sending a payment request
    alert(`Payment request sent for UPI ID: ${upiId}`);
  };

  return (
    <div style={{ display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center', minHeight: '100vh' }}>
      <div style={{ textAlign: 'center', marginBottom: '20px' }}>
        {/* Display QR code here */}
        <img src="/qr.jpg" alt="QR Code" style={{ maxWidth: '200px', marginBottom: '20px' }} />
      </div>

      <div style={{ textAlign: 'center' }}>
        {/* Button to pay with UPI */}
        <button onClick={() => handlePayWithUPI('upi://pay')} style={{ backgroundColor: 'blue', color: 'white', padding: '10px 20px', border: 'none', borderRadius: '5px', cursor: 'pointer' }}>
          Pay with UPI
        </button>
      </div>

      {showPaymentForm && (
        <form onSubmit={handleSubmitPayment} style={{ marginTop: '20px', color: 'white', textAlign: 'center' }}>
          {/* Input fields for payment details */}
          <input type="text" name="upiId" placeholder='Enter UPI ID' required style={{ marginLeft: '10px', padding: '5px', borderRadius: '5px', border: '1px solid #ccc', color: 'black' }} />
          <br />
          <br />
          <button type="submit" style={{ backgroundColor: 'orange', color: 'white', padding: '10px 20px', border: 'none', borderRadius: '5px', cursor: 'pointer', marginTop: '10px' }}>
            Submit Payment
          </button>
        </form>
      )}
    </div>
  );
};

export default Payment;
