import React, { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import axios from 'axios';

interface CartContextType {
  totalQuantity: number;
  fetchCartItems: () => void;
}

const CartContext = createContext<CartContextType | undefined>(undefined);

export const CartProvider = ({ children }: { children: ReactNode }) => {
  const [totalQuantity, setTotalQuantity] = useState<number>(0);

  // Hàm lấy dữ liệu giỏ hàng từ API
  const fetchCartItems = async () => {
    try {
      const token = localStorage.getItem('token');
      const user = localStorage.getItem('user');
      
      let parsedUser;
      try {
        parsedUser = JSON.parse(user!);
      } catch (error) {
        console.error('Lỗi khi phân tích dữ liệu người dùng:', error);
        return;
      }

      if (parsedUser) {
        const userId = parsedUser.user ? parsedUser.user.id : parsedUser.id;
        
        if (!userId) {
          console.error('Không tìm thấy ID người dùng.');
          setTotalQuantity(0);
          return;
        }

        try {
          const response = await axios.get(`http://127.0.0.1:8000/api/cart/${userId}`, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          });
          
          if (response.data && response.data.cart_items) {
            const total = response.data.cart_items.length;
            setTotalQuantity(total);
          } else {
            setTotalQuantity(0);
          }
        } catch (error) {
          console.error('Lỗi khi lấy giỏ hàng:', error);
          setTotalQuantity(0);
        }
      } else {
        console.error('Không tìm thấy thông tin người dùng.');
        setTotalQuantity(0);
      }
    } catch (error) {
      console.error('Lỗi khi lấy dữ liệu giỏ hàng:', error);
      // Nếu API fail, set về 0 để tránh crash
      setTotalQuantity(0);
    }
  };

  useEffect(() => {
    fetchCartItems();
  }, []);

  return (
    <CartContext.Provider value={{ totalQuantity, fetchCartItems }}>
      {children}
    </CartContext.Provider>
  );
};

export const useCart = (): CartContextType => {
  const context = useContext(CartContext);
  if (context === undefined) {
    throw new Error('useCart phải được sử dụng trong CartProvider');
  }
  return context;
};
