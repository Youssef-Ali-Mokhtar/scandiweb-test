import { useState } from "react";
import Navbar from "../layouts/Navbar";
import { useNavigate } from "react-router-dom";


//An object used inside getProductProperties function to assign the fields to each product dynamically
const productMap = {
    DVD:["size"],
    Book:["weight"],
    Furniture:["length","width","height"]
}

//A function that returns only the fields specific to the chosen product type
const getProductProperties = (type, values)=>{
    const properties = productMap[type];
    return Object.keys(values).reduce((acc, currentValue)=>{
        if(properties.includes(currentValue)){
            acc[currentValue] = values[currentValue];
        }
        return acc;
    }, {})
}

//RegEx object of strings to check validity of input fields
const regEx = {
    sku:/^[a-zA-Z0-9_-]{3,}$/,
    name:/^[a-zA-Z\d\s_-]+$/,
    price:/^\d+(\.\d{1,2})?$/,
    size:/^\d+$/,
    product_type:/(Book|Furniture|DVD)/i,
    weight:/^\d+$/,
    height:/^\d+$/,
    width:/^\d+$/,
    length:/^\d+$/
}

//The beginning of the components
const AddProduct = () => {
    const navigate = useNavigate();

    //A state for the input values
    const [values, setValues] = useState({
        sku: '',
        name: '',
        price: '',
        product_type: '',
        length: '',
        width: '',
        height: '',
        weight: '',
        size: '',
    });

    //A state for the validity of input values
    const [isValid, setIsValid] = useState({
        sku: true,
        name: true,
        price: true,
        product_type: true,
        length: true,
        width: true,
        height: true,
        weight: true,
        size: true,
    });

    //A state to check of input values
    const [isEmpty, setIsEmpty] = useState({
        sku: false,
        name: false,
        price: false,
        product_type: false,
        length: false,
        width: false,
        height: false,
        weight: false,
        size: false,
    });

    //It retrieves data from the fields and updates the state of the values
    const handleChange = (event) => {
        const { name, value } = event.target;
        setValues((prevData)=>({
            ...prevData,
            [name]:value,
        }));
    };

    //If the product type is determined, it returns only the fields explusive to the chosen type
    //If not, it returns all the fields
    const getSubmittedValues = ()=>{
        if(values.product_type){
            const temp = getProductProperties(values.product_type, values);
            const submittedValue =
                {...temp,sku:values.sku,
                 name:values.name, 
                 price:values.price, 
                 product_type:values.product_type};
            return submittedValue;
        }else{
            return values;
        }
    }

    //Submit function
    const handleSubmit = ()=>{

        let flag = false;


        let checkedValues = getSubmittedValues();

        //Check if there are empty or invalid inputs
        for (let key in checkedValues) {
            if (checkedValues[key].trim()==='') {
                setIsEmpty((prev)=>({...prev,[key]:true}));
                setIsValid((prev)=>({...prev,[key]:true}));
                flag = true;
            }else{
                setIsEmpty((prev)=>({...prev,[key]:false}));
                if(regEx[key].test(checkedValues[key])){
                    setIsValid((prev)=>({...prev,[key]:true}));
                }else{
                    setIsValid((prev)=>({...prev,[key]:false}));
                    flag = true;
                }
            }
        }

        //If there is invalid or empty inputs, the function gets terminated
        if(flag){
            return;
        }


        //POST request to add product
        fetch('http://localhost/scandiweb/index.php', {
              method: 'POST',
              body: JSON.stringify({submit:checkedValues}),
          })
            .then(response => {
              if (response.ok) {
                console.log('Product added successfully');
              } else {
                // Error occurred during deletion, handle the error
                console.error('Failed to delete products');
              }
              return response.json();
            })
            .then(data=>{
                console.log(data);
                setValues({
                    sku: '',
                    name: '',
                    price: '',
                    product_type: '',
                    length: '',
                    width: '',
                    height: '',
                    weight: '',
                    size: '',
                  });
                navigate("/");
            })
            .catch(error => {
              // Network error or other exception occurred, handle the error
              console.error('Error:', error);
            });
            
    }

    //Save button passed to the navbar
    const buttonOne = {
        label:'Save',
        color:'rgb(7, 62, 180)',
        func:()=>{
            console.log("Save product!");
            handleSubmit();
        }
    }

    //Cancel button passed to the navbar
    const buttonTwo = {
        label:'Cancel',
        color:'rgb(187, 43, 57)',
        func:()=>{
            console.log("Cancel product!");
            setValues({
                sku: '',
                name: '',
                price: '',
                product_type: '',
                length: '',
                width: '',
                height: '',
                weight: '',
                size: '',
              });
              navigate('/');
        }
    }
    return ( <>
        {/* Navbar */}
        <Navbar title="Product Add" buttonOne={buttonOne} buttonTwo={buttonTwo} />

        {/* Add product page */}
        <div className='page' style={{justifyContent:'flex-start', alignItems:'flex-start'}}>

            {/* Form tag */}
            <form className="product-add-form" id="product_form">

                {/* SKU field and it's warning messages */}
                <div className="input-row">
                    <label htmlFor="sku">SKU</label>
                    <input type="text" value={values.sku} onChange={handleChange} name="sku" id="sku" required/>
                </div>
                {isEmpty['sku']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit sku</p>}
                {!isValid['sku']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                    Please provide a value containing only letters, underscores, hyphens, and a minimum of 3 characters.
                </p>}

                {/* Name field and it's warning messages */}
                <div className="input-row">
                    <label htmlFor="name">Name</label>
                    <input type="text" value={values.name} onChange={handleChange} name="name"  id="name" required/>
                </div>
                {isEmpty['name']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit name</p>}
                {!isValid['name']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                    Please provide a value containing only letters, optional whitespace, digits, underscore, or hyphen.
                </p>}

                {/* Price field and it's warning messages */}
                <div className="input-row">
                    <label htmlFor="price">Price ($)</label>
                    <input type="number" value={values.price} onChange={handleChange} name="price" id="price" required/>
                </div>
                {isEmpty['price']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit price</p>}
                {!isValid['price']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                    Please provide a value that is a positive number with up to two decimal places.
                </p>}

                {/* Price field and it's warning messages */}
                <div className="input-row">
                    <label htmlFor="product_type">Type Switcher</label>
                    <select 
                        id="productType" 
                        className="" 
                        value={values.product_type}
                        onChange={handleChange}
                        name="product_type"
                        required>
                            <option value="">Type Switcher</option>
                            <option value="DVD">DVD</option>
                            <option value="Book">Book</option>
                            <option value="Furniture">Furniture</option>
                    </select>
                </div>
                {isEmpty['product_type']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, choose a type</p>}


                {/* Conditional DVD field and it's warning messages */}
                {values.product_type === "DVD" && (
                    <>
                        <div className="input-row">
                            <label htmlFor="size">Size (MB)</label>
                            <input type="number" value={values.size} onChange={handleChange} name="size" id="size" required/>
                        </div>
                        {isEmpty['size']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit size</p>}
                        {!isValid['size']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive integer representing the size in megabytes (MB).
                        </p>}
                        <p className="product-description">Please, provide disc space in MB</p>
                    </>
                )}

                {/* Conditional Book field and it's warning messages */}
                {values.product_type === "Book" && (
                    <>
                        <div className="input-row">
                            <label htmlFor="weight">Weight (KG)</label>
                            <input type="number" value={values.weight} onChange={handleChange} name="weight" id="weight" required/>
                        </div>
                        {isEmpty['weight']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit weight</p>}
                        {!isValid['weight']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive integer representing the weight in kilograms (KG).
                        </p>}
                        <p className="product-description">Please, provide weight in Kg</p>
                    </>
                )}

                {/* Conditional Furniture fields and their warning messages */}
                {values.product_type === "Furniture" && (
                    <>
                        <div className="input-row">
                            <label htmlFor="height">Height (CM)</label>
                            <input type="number" value={values.height} onChange={handleChange} name="height" id="height" required/>
                        </div>
                        {isEmpty['height']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit height</p>}
                        {!isValid['height']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive integer representing the height in centimeters (CM).
                        </p>}
                        <div className="input-row">
                            <label htmlFor="width">Width (CM)</label>
                            <input type="number" value={values.width} onChange={handleChange} name="width" id="width" required/>
                        </div>
                        {isEmpty['width']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit width</p>}
                        {!isValid['width']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive integer representing the width in centimeters (CM).
                        </p>}
                        <div className="input-row">
                            <label htmlFor="length">Length (CM)</label>
                            <input type="number" value={values.length} onChange={handleChange} name="length" id="length" required/>
                        </div>
                        {isEmpty['length']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit length</p>}
                        {!isValid['length']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive integer representing the length in centimeters (CM).
                        </p>}
                        <p className="product-description">Please, provide dimensions in HxWxL format</p>
                    </>
                )}

            </form>
        </div>
    </> );
}

export default AddProduct;