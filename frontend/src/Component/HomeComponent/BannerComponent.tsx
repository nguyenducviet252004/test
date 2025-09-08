import React from 'react';
import api from '../../Axios/Axios';
import { Swiper, SwiperSlide } from 'swiper/react';
import { Navigation, Pagination } from 'swiper/modules';
import Banner from '../../assets/imgs/page/homepage1/MU.jpg';
import BannerTwo from '../../assets/imgs/page/homepage1/e7cqmizxsaetkan-1511.jpg';
import Sale from '../../assets/imgs/page/homepage1/sale.png';
// import Leaf from '../../assets/imgs/page/homepage1/leaf.png'
import Star from '../../assets/imgs/page/homepage1/star.png'
import Arrow from '../../assets/imgs/template/icons/arrow.svg'
import { useEffect, useState } from 'react';
const BannerComponent: React.FC = () => {
 
    const [activeBanners, setActiveBanners] = useState<any[]>([]);
    
    useEffect(() => {
        const getBanners = async () => {
            try {
                const { data } = await api.get('/logobanner');
                const banners = data['1']; // Lấy danh sách banner từ key '1'
                if (banners && Array.isArray(banners)) {
                    const active = banners.filter((b: any) => b.is_active === 1);
                    setActiveBanners(active);
                }
            } catch (error) {
                console.error("Không thể tải banners:", error);
                setActiveBanners([]); 
            }
        };
        getBanners();
    }, []);

      
    

    return (
        <section className="section banner-homepage1">
            <div className="container">
                <div className="box-swiper">
                    <Swiper
                        modules={[Navigation, Pagination]}
                        navigation
                        pagination={{ clickable: true }}
                        className="swiper-banner pb-0"
                    >
                        {activeBanners.length > 0 ? (
                            activeBanners.map((b, index) => (
                                <SwiperSlide key={b.id}>
                                    <div className="box-banner-home1">
                                        <div
                                            className="box-cover-image wow animate__animated animate__fadeInLeft"
                                            style={{ 
                                                backgroundImage: `url(${b.image})`,
                                                backgroundSize: 'cover',
                                                backgroundPosition: 'center center',
                                                backgroundRepeat: 'no-repeat'
                                            }}
                                        />
                                        <div className="box-banner-info">
                                            <div className="blockleaf rotateme">
                                                {/* <img src={index % 2 === 0 ? Leaf : Star} alt="Kidify" /> */}
                                            </div>
                                            <div className="block-info-banner">
                                                <p className="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">{b.title}</p>
                                                <h2 className="heading-banner mb-10 wow animate__animated animate__zoomIn">
                                                    <span className="text-up">{b.description}</span>
                                                    <span className="text-under">{b.description}</span>
                                                </h2>
                                                <h4 className="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">
                                                    {index % 2 === 0 ? "Sport For You" : "Sport Is King"}
                                                </h4>
                                                <div className="text-center mt-10">
                                                    <a className="btn btn-double-border wow animate__animated animate__zoomIn" href="/product">
                                                        <span>Mua sắm ngay</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </SwiperSlide>
                            ))
                        ) : (
                            <>
                                <SwiperSlide>
                                    <div className="box-banner-home1">
                                        <div
                                            className="box-cover-image wow animate__animated animate__fadeInLeft"
                                            style={{ backgroundImage: `url(${Banner})` }}
                                        />
                                        <div className="box-banner-info">
                                            <div className="blockleaf rotateme">
                                                {/* <img src={Leaf} alt="Kidify" /> */}
                                            </div>
                                            <div className="block-info-banner">
                                                <p className="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Khuyến mãi đặc biệt</p>
                                                <h2 className="heading-banner mb-10 wow animate__animated animate__zoomIn">
                                                    <span className="text-up">Giảm giá lên đến 50%</span>
                                                    <span className="text-under">Giảm giá lên đến 50%</span>
                                                </h2>
                                                <h4 className="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Sport For You</h4>
                                                <div className="text-center mt-10">
                                                    <a className="btn btn-double-border wow animate__animated animate__zoomIn" href="/product">
                                                        <span>Mua sắm ngay</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </SwiperSlide>
                                <SwiperSlide>
                                    <div className="box-banner-home1">
                                        <div
                                            className="box-cover-image wow animate__animated animate__fadeInLeft"
                                            style={{ backgroundImage: `url(${BannerTwo})` }}
                                        />
                                        <div className="box-banner-info wow animate__animated animate__zoomIn">
                                            <div className="blockleaf rotateme">
                                                <img src={Star} alt="Kidify" />
                                            </div>
                                            <div className="block-info-banner">
                                                <p className="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Sản phẩm mới</p>
                                                <h2 className="heading-banner mb-10 wow animate__animated animate__zoomIn">
                                                <span className="text-up">Bộ sưu tập mới nhất</span>
                                                <span className="text-under">Bộ sưu tập mới nhất</span>
                                                </h2>
                                                <h4 className="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Sport Is King</h4>
                                                <div className="text-center mt-10">
                                                    <a className="btn btn-double-border wow animate__animated animate__zoomIn" href="/product">
                                                        <span>Mua sắm ngay</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </SwiperSlide>
                            </>
                        )}
                    </Swiper>
                </div>
            </div>
        </section>
    );
};

export default BannerComponent;
