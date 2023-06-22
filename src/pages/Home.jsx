import { useState, useEffect } from "react";
import ProductCard from "../components/ProductCard";
import Navbar from "../layouts/Navbar";
import { useNavigate } from "react-router-dom";

const Home = () => {
    const navigate = useNavigate();
    const [data, setData] = useState([]);
    const [checkedCards, setCheckedCards] = useState([]);

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

    useEffect(() => {    
        fetch('https://scandiweb-youssef.000webhostapp.com/index.php')
            .then(response => response.json())
            .then(data => {
                // Process the received data
                setData(data);
            })
            .catch(error => {
                // Handle any errors
                console.error(error);
            });
    }, []);


    const buttonOne = {
        label:'ADD',
        color:'orange',
        func:()=>{
            console.log("NAVIGATE TO PRODUCT ADD");
            navigate('/add-product');
        }
    }

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
        <Navbar title="Product List" buttonOne={buttonOne} buttonTwo={buttonTwo} />
        <div className='page' >
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