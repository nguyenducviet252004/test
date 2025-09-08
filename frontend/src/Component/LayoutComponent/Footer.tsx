import Logo from "../../assets/imgs/template/110.jpg";
import { useEffect, useState } from "react";
import axios from "axios";
const Footer: React.FC = () => {

  const [ isLogo, setLogo] = useState<any>()
   

  useEffect(()=>{
    const GetLogo = async () => {
      try {
        const { data } = await axios.get(`http://127.0.0.1:8000/api/logobanner`);
        const logos = data['2']; // Lấy danh sách logo từ key '2'
        if (logos && Array.isArray(logos) && logos.length > 0) {
          const latestLogo = [...logos].sort((a, b) => b.id - a.id)[0];
          if (latestLogo && latestLogo.image) {
            setLogo(latestLogo.image);
          } else {
            setLogo(Logo);
          }
        } else {
          setLogo(Logo);
        }
      } catch (error) {
         console.error("Lỗi khi tải logo footer:", error);
         // Sử dụng logo mặc định nếu API fail
         setLogo(Logo);
      }
    };
    GetLogo()
  },[])
  return (
    <>
      <footer className="footer">
        <div className="footer-1">
          <div className="container">
            <div
              className="row"
              style={{ display: "flex", justifyContent: "start" }}
            >
              <div
                className="col-lg-3 col-md-3 mb-30 wow animate__animated animate__fadeIn"
                data-wow-delay=".0s"
              >
                <h5 className="neutral-900 text-uppercase mb-30">LIÊN HỆ</h5>
                <p className="neutral-900 font-lg desc-company">
                  Số 22, ngõ 20/4 phố Nghĩa Đô, Cầu Giấy, Hà Nội
                </p>
                <p className="neutral-900 font-lg phone-footer">
                  +84 (0)0976462724
                </p>
                <p className="neutral-900 font-lg email-footer">
                  110Store@gmail.com
                </p>
              </div>
              {/* <div className="col-lg-9 mb-30">
          <div className="row">
            <div className="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
              <h5 className="neutral-900 text-uppercase mb-30">Company</h5>
              <ul className="menu-footer">
                <li><a href="about.html">About us</a></li>
                <li><a href="#">Our Experts</a></li>
                <li><a href="#">Services &amp; Price</a></li>
                <li><a href="blog-2.html">Latest News</a></li>
                <li><a href="#">Support Center</a></li>
              </ul>
            </div>
            <div className="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".2s">
              <h5 className="neutral-900 text-uppercase mb-30">Customers</h5>
              <ul className="menu-footer">
                <li><a href="contact.html">Contact us</a></li>
                <li><a href="#">Payment &amp; Tax</a></li>
                <li><a href="#">Bonus Point</a></li>
                <li><a href="#">Supply Chain</a></li>
                <li><a href="#">Student Discount</a></li>
              </ul>
            </div>
            <div className="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
              <h5 className="neutral-900 text-uppercase mb-30">SUPPORT</h5>
              <ul className="menu-footer">
                <li><a href="#">Shipping Info</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Refund</a></li>
                <li><a href="#">How To Order</a></li>
                <li><a href="#">How To Track</a></li>
              </ul>
            </div>
            <div className="col-lg-3 col-md-6 mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
              <h5 className="neutral-900 text-uppercase mb-30">social</h5>
              <ul className="menu-footer">
                <li><a className="facebook" href="#">Facebook</a></li>
                <li><a className="twitter" href="#">Twitter</a></li>
                <li><a className="instagram" href="#">Instagram</a></li>
                <li><a className="pinterest" href="#">Pinterest</a></li>
                <li><a className="youtube" href="#">Youtube</a></li>
              </ul>
            </div>
          </div>
        </div> */}
            </div>
          </div>
        </div>
        <div className="footer-2">
          <div className="container">
            <div className="footer-bottom">
              <div className="row align-items-center">
                <div
                  className="col-lg-3 col-md-12 text-center text-lg-start mb-20 wow animate__animated animate__fadeIn"
                  data-wow-delay=".0s"
                >
                  <div>
                    <img src={isLogo} alt="" width={'100px'} />
                  </div>
                </div>
                <div
                  className="col-lg-6 col-md-12 text-center mb-20 wow animate__animated animate__fadeIn"
                  data-wow-delay=".0s"
                >
                  <span className="body-p1 neutral-900 mr-5">©2025</span>
                  <a href="#">110Store</a>
                </div>
                <div
                  className="col-lg-3 col-md-12 text-center text-lg-end mb-20 wow animate__animated animate__fadeIn"
                  data-wow-delay=".0s"
                >
                  <div className="d-flex justify-content-center justify-content-lg-end align-items-center box-all-payments">
                    {/* <div className="d-inline-block box-payments">
                      <img src={MasterCart} alt="kidify" />
                      <img src={GooglePay} alt="kidify" />
                      <img src={Payoneer} alt="kidify" />
                    </div> */}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </>
  );
};

export default Footer;
