import { BrowserRouter } from 'react-router-dom';
import { Provider } from 'react-redux';
import { PersistGate } from 'redux-persist/integration/react';

import { store, persistor } from '~/store';
import AppRouter from '~/routers/AppRouters';
import { GlobalStyle } from '~/components/';

function App() {
  console.log(process.env.REACT_APP_DOMAIN_URL);
  console.log(process.env.REACT_APP_DOMAIN);
  return (
    <Provider store={store}>
      <PersistGate loading={null} persistor={persistor}>
        <BrowserRouter>
          <GlobalStyle>
            <div className="App">
              <AppRouter />
            </div>
          </GlobalStyle>
        </BrowserRouter>
      </PersistGate>
    </Provider>
  )
};

export default App;