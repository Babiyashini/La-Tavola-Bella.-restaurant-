// Add selected item to local storage and go to order page
function addToOrder(name, price) {
  const order = { name, price };
  localStorage.setItem("order", JSON.stringify(order));
  window.location.href = "order.html";
}

// On order page, show summary
document.addEventListener("DOMContentLoaded", () => {
  const order = JSON.parse(localStorage.getItem("order"));
  const summaryDiv = document.getElementById("order-summary");

  if (order && summaryDiv) {
    summaryDiv.innerHTML = `
      <h2>Order Summary</h2>
      <p><strong>Item:</strong> ${order.name}</p>
      <p><strong>Total:</strong> $${order.price.toFixed(2)}</p>
    `;
  }

  const form = document.getElementById("order-form");
  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault();

      const customer = {
        name: document.getElementById("customer-name").value,
        address: document.getElementById("customer-address").value,
        phone: document.getElementById("customer-phone").value,
        order
      };

      console.log("Order Data:", customer);

      // Later you’ll send this to AWS EC2 backend like:
      /*
      fetch("https://your-ec2-endpoint/api/orders", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(customer)
      })
      .then(res => res.json())
      .then(data => alert("Order placed successfully!"))
      .catch(err => console.error(err));
      */

      alert(`Thank you, ${customer.name}! Your order for ${order.name} has been received.`);
      localStorage.removeItem("order");
      form.reset();
    });
  }
});
