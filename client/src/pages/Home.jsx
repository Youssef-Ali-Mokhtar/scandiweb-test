import { useState, useEffect } from "react";
import ProductCard from "../components/ProductCard";
import Navbar from "../layouts/Navbar";
import { useNavigate } from "react-router-dom";

const Home = () => {
    const navigate = useNavigate();
    const [data, setData] = useState([]);
    const [checkedCards, setCheckedCards] = useState([]);

    //A function to accumalates the SKUs of the checked products to be deleted
    const handleDeletedCards = (Id, isChecked)=>{
        if(isChecked){
            setCheckedCards(prev=>[...prev, Id])
        }else{
            const filteredCards = checkedCards.filter(cardId=>(
                cardId !== Id
            ))
            setCheckedCards(filteredCards);
        }
    }

    //A function to accumalates the SKUs of the checked products to be deleted
    useEffect(() => {    
        fetch('https://scandiweb-youssef.000webhostapp.com/index.php')
            .then(response => response.json())
            .then(data => {
                // Process the received data
                setData(data);
                console.log(data);
            })
            .catch(error => {
                // Handle any errors
                console.error(error);
            });
    }, []);

    //Add button passed to the navbarincluding the function that navigates to product add prage
    const buttonOne = {
        label:'ADD',
        color:'orange',
        func:()=>{
            console.log("NAVIGATE TO PRODUCT ADD");
            navigate('/add-product');
        }
    }

    //Mass delete button passed to the navbar including the mass delete function
    const buttonTwo = {
        label:'MASS DELETE',
        color:'rgb(187, 43, 57)',
        func:()=>{
            const filteredData = data.filter((productData)=>(
                !checkedCards.includes(productData.sku)
            ));
            if(checkedCards.length>0){
                fetch('https://scandiweb-youssef.000webhostapp.com/index.php', {
                    method: 'POST',
                    body: JSON.stringify({delete:checkedCards}),
                })
                    .then(response => {
                    if (response.ok) {
                        setData(filteredData);
                        setCheckedCards([]);
                        console.log('Products deleted successfully');
                    } else {
                        // Error occurred during deletion, handle the error
                        console.error('Failed to delete products');
                    }
                    return response.json();
                    })
                    .then(data=>{
                        console.log(data);
                    })
                    .catch(error => {
                    // Network error or other exception occurred, handle the error
                    console.error('Error:', error);
                    });
            }
        }
    }

    return ( <>
        {/* Navigation bar */}
        <Navbar title="Product List" buttonOne={buttonOne} buttonTwo={buttonTwo} />
        {/* Products list page */}
        <div className='page' >
            {/* Listed products container */}
            <div className='cards-container'>
            {    
                data.map(item=>(
                    <ProductCard key={item.sku} specs={item} handleDeletedCards={handleDeletedCards}/>
                ))
            } 
            </div>
        </div>
    </> );
}
 
export default Home;