import { useSelector } from 'react-redux';
import { Route, Routes } from 'react-router-dom';

import { userSelector } from '~/store';
import { public_routers, private_routers } from '~/routers';
import { NotFoundPage } from "../pages";
import { useNavigate  } from 'react-router-dom';

function AppRouter() {
    const navigate  = useNavigate();
    const user = useSelector(userSelector);

    return (
        <Routes>
            {public_routers.length > 0 &&
                public_routers.map((route, index) => {
                    let Layout = 'div';
                    if (route.layout) Layout = route.layout;
                    return <Route path={route.path} key={index} element={<Layout>{route.element}</Layout>} />;
                })
            }

            {/* Định nghĩa các router riêng tư của trang */}
            {console.log(user?.access_token)};
            {user?.access_token ?(
                private_routers.map((route, index) => {
                    let Layout = 'div';
                    if (route.layout) Layout = route.layout;
                    return <Route path={route.path} key={index} element={<Layout>{route.element}</Layout>} />;
                })) : (
                   ()=> navigate('/canbots-login')
                )
            }
            <Route path='*' element={<NotFoundPage />} />
        </Routes>
    );
}

export default AppRouter;
