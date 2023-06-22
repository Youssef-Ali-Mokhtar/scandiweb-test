import { useState } from "react";
import Navbar from "../layouts/Navbar";
import { useNavigate } from "react-router-dom";

const productMap = {
    DVD:["size"],
    Book:["weight"],
    Furniture:["length","width","height"]
}

const getProductProperties = (type, values)=>{
    const properties = productMap[type];
    return Object.keys(values).reduce((acc, currentValue)=>{
        if(properties.includes(currentValue)){
            acc[currentValue] = values[currentValue];
        }
        return acc;
    }, {})
}

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

const AddProduct = () => {
    const navigate = useNavigate();

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

    const handleChange = (event) => {
        const { name, value } = event.target;
        setValues((prevData)=>({
            ...prevData,
            [name]:value,
        }));
    };

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

    const handleSubmit = ()=>{

        let flag = false;

        let checkedValues = getSubmittedValues();

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

        if(flag){
            return;
        }


        fetch('https://scandiweb-youssef.000webhostapp.com/index.php', {
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

    const buttonOne = {
        label:'Save',
        color:'rgb(7, 62, 180)',
        func:()=>{
            console.log("Save product!");
            handleSubmit();
        }
    }

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
        <Navbar title="Product Add" buttonOne={buttonOne} buttonTwo={buttonTwo} />

        <div className='page' style={{justifyContent:'flex-start', alignItems:'flex-start'}}>
            <form className="product-add-form" id="product_form">
                <div className="input-row">
                    <label htmlFor="sku">SKU</label>
                    <input type="text" value={values.sku} onChange={handleChange} name="sku" id="sku" required/>
                </div>
                {isEmpty['sku']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit sku</p>}
                {!isValid['sku']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                    Please provide a value containing only letters, underscores, hyphens, and a minimum of 3 characters.
                </p>}
                <div className="input-row">
                    <label htmlFor="name">Name</label>
                    <input type="text" value={values.name} onChange={handleChange} name="name"  id="name" required/>
                </div>
                {isEmpty['name']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit name</p>}
                {!isValid['name']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                    Please provide a value containing only letters, optional whitespace, digits, underscore, or hyphen.
                </p>}
                <div className="input-row">
                    <label htmlFor="price">Price ($)</label>
                    <input type="number" value={values.price} onChange={handleChange} name="price" id="price" required/>
                </div>
                {isEmpty['price']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit price</p>}
                {!isValid['price']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                    Please provide a value that is a positive number with up to two decimal places.
                </p>}
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

                {values.product_type === "Book" && (
                    <>
                        <div className="input-row">
                            <label htmlFor="weight">Weight (KG)</label>
                            <input type="number" value={values.weight} onChange={handleChange} name="weight" id="weight" required/>
                        </div>
                        {isEmpty['weight']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit weight</p>}
                        {!isValid['weight']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive number representing the weight in kilograms (KG).
                        </p>}
                        <p className="product-description">Please, provide weight in Kg</p>
                    </>
                )}

                {values.product_type === "Furniture" && (
                    <>
                        <div className="input-row">
                            <label htmlFor="height">Height (CM)</label>
                            <input type="number" value={values.height} onChange={handleChange} name="height" id="height" required/>
                        </div>
                        {isEmpty['height']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit height</p>}
                        {!isValid['height']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive number representing the height in centimeters (CM).
                        </p>}
                        <div className="input-row">
                            <label htmlFor="width">Width (CM)</label>
                            <input type="number" value={values.width} onChange={handleChange} name="width" id="width" required/>
                        </div>
                        {isEmpty['width']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit width</p>}
                        {!isValid['width']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive number representing the width in centimeters (CM).
                        </p>}
                        <div className="input-row">
                            <label htmlFor="length">Length (CM)</label>
                            <input type="number" value={values.length} onChange={handleChange} name="length" id="length" required/>
                        </div>
                        {isEmpty['length']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>Please, submit length</p>}
                        {!isValid['length']&&<p style={{color:'red', textAlign:'start',paddingBottom:'10px'}}>
                            Please provide a value that is a positive number representing the length in centimeters (CM).
                        </p>}
                        <p className="product-description">Please, provide dimensions in HxWxL format</p>
                    </>
                )}
            </form>
        </div>
    </> );
}

export default AddProduct;