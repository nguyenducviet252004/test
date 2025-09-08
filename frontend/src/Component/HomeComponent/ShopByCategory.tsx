import React, { useEffect, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import axios from 'axios';
import Image from '../../assets/imgs/template/icons/CategoryIcon24-1.svg';
import { RootState, useAppDispatch } from '../../Redux/store';
import { fetchCategories, setActiveTab } from '../../Redux/Reducer/CategoriesReducer';
import { Link } from 'react-router-dom';
import Arrow from '../../assets/imgs/template/icons/arrow.svg';
import { IProduct } from '../../types/cart';
import api from '../../Axios/Axios';

const ShopByCategory: React.FC = () => {
    const dispatch = useAppDispatch();
    const { categories, activeTab } = useSelector((state: RootState) => state.categories);
    const [allProducts, setAllProducts] = useState<IProduct[]>([]);
    const [bannerUrl, setBannerUrl] = useState('');

    useEffect(() => {
        const getBanner = async () => {
            try {
                const { data } = await axios.get(`http://127.0.0.1:8000/api/logobanner`);
                const activeBanner = data?.banner?.find((item: any) => item.is_active === 1);
                if (activeBanner && activeBanner.image) {
                    setBannerUrl(activeBanner.image);
                }
            } catch (error) {
                console.error("Không thể tải banner:", error);
            }
        };
        getBanner();
    }, []);

    useEffect(() => {
        dispatch(fetchCategories());
        const fetchAllProducts = async () => {
            try {
                const { data } = await api.get('/products');
                setAllProducts(data.products);
                // Set the first category as active if none is selected
                if (data.products.length > 0 && categories.length > 0 && activeTab === 'all') {
                    dispatch(setActiveTab(categories[0].id.toString()));
                }
            } catch (error) {
                console.error("Failed to fetch products:", error);
            }
        };
        fetchAllProducts();
    }, [dispatch, categories, activeTab]);

    const handleCategoryClick = (categoryId: number) => {
        dispatch(setActiveTab(categoryId.toString()));
    };

    // Memoize the filtering logic to prevent re-calculation on every render
    const displayedProducts = React.useMemo(() => {
        if (!activeTab || activeTab === 'all') {
            // Optionally, show all products or a default set if no tab is active
            return allProducts.slice(0, 8); // Show first 8 products as a default
        }
        return allProducts.filter(p => p.categories?.id.toString() === activeTab);
    }, [allProducts, activeTab]);

    return (
        <section className="section block-section-3">
            <div className="container">
                {bannerUrl && <img src={bannerUrl} alt="Banner" style={{ width: '100%', height: 'auto', marginBottom: '30px', borderRadius: '8px' }} />}
                <div className="top-head">
                    <h4 className="text-uppercase brand-1 wow animate__animated animate__fadeIn">Shop by Category</h4>
                    <a className="btn btn-arrow-right wow animate__animated animate__fadeIn" href="/product">
                        View All <img src={Arrow} alt="Kidify" />
                    </a>
                </div>
                <div className="row">
                    <div className="col-lg-3">
                        <div className="box-category-list mb-30">
                            <ul className="menu-category">
                                {categories.map(category => (
                                    <li key={category.id} className="wow animate__animated animate__fadeIn" data-wow-delay=".0s">
                                        <p
                                            style={{ cursor: 'pointer' }}
                                            className={activeTab === category.id.toString() ? 'active' : ''}
                                            onClick={() => handleCategoryClick(category.id)}
                                        >
                                            <img src={Image} alt={category.name} />
                                            {category.name}
                                        </p>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                    <div className="col-lg-9">
                        <div className="row">
                            {displayedProducts.length > 0 ? (
                                displayedProducts.map(product => (
                                    <div key={product.id} className="col-lg-3 col-md-4 col-sm-6 wow animate__animated animate__fadeIn">
                                        <div className="cardProduct wow fadeInUp" style={{ height: '100%' }}>
                                            <div className="cardImage" style={{ height: '270px', overflow: 'hidden' }}>
                                                <label className="lbl-hot">hot</label>
                                                <Link to={`/product-detail/${product.id}`}>
                                                    <div style={{ height: '100%' }}>
                                                        <img className="imageMain" src={product.avatar_url} alt={product.name} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                                        <img className="imageHover" src={product.avatar_url} alt={product.name} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                                    </div>
                                                </Link>
                                                <div className="button-select">
                                                    <Link to={`/product-detail/${product.id}`}>Add to Cart</Link>
                                                </div>
                                            </div>
                                            <div className="cardInfo">
                                                <Link to={`/product-detail/${product.id}`}>
                                                    <h6 className="font-md-bold cardTitle">{product.name}</h6>
                                                </Link>
                                                <p className="font-lg cardDesc">
                                                    {Math.round(product.price ?? 0).toLocaleString(
                                                        "vi-VN",
                                                        { style: "currency", currency: "VND" }
                                                    )}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <p>No products available in this category.</p>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default ShopByCategory;
