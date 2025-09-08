import "./thank.css";
import { DeleteOutlined, CheckOutlined } from "@ant-design/icons";
import { useEffect } from "react";
import { useAppDispatch } from "../Redux/store";
import { clearCart } from "../Redux/Reducer/CartReducer";

function ThankYou() {
  const dispatch = useAppDispatch();

  useEffect(() => {
    // Xóa giỏ hàng khi thanh toán online thành công
    const user = localStorage.getItem("user");
    if (user) {
      try {
        const parsedUser = JSON.parse(user);
        const userId = parsedUser.user?.id || parsedUser.id;
        if (userId) {
          dispatch(clearCart(Number(userId)));
        }
      } catch (error) {
        console.error("Error parsing user data:", error);
      }
    }
    // Xóa localStorage
    localStorage.removeItem("cartItems");
  }, [dispatch]);

  return (
    <>
      <section className="thank">
        <div className="thanks">
          <div style={{display:'flex', justifyContent:'center', marginTop:'60px'}}>
            <div className="icon-thank">
              <CheckOutlined
                style={{ fontSize: "30px", color: "rgb(82,196,26)" }}
              />
            </div>
          </div>

          <span className="text-succsess">Thanh toán thành công</span>
          <p className="text-thank">Cảm ơn quý khách đã ủng hộ !</p>
        </div>
      </section>
    </>
  );
}
export default ThankYou;
