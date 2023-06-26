import './App.css';
import Home from './pages/Home';
import AddProduct from './pages/AddProduct';
import Footer from './layouts/Footer';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';



function App() {
  return (
    <Router basename='/scandiweb-test'>
        <div className="App">
        <Routes>
            <Route index element={<Home />} />
            <Route path="add-product" element={<AddProduct />} />
        </Routes>
        <Footer/>
        </div>
    </Router>
  );
}

export default App;
