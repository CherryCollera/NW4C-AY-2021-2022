import React, { forwardRef, useState } from 'react'
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";

function DateComp(props) {

  function selDateHandler(a, b) {
    props.selDate(a, b);
  }


  const [startDate, setStartDate] = useState(props.strDate);
  const maxDate = props.strDate;
  const ExampleCustomInput = forwardRef(({ value, onClick }, ref) => (
    <div className='field margiNFIx' onClick={onClick}>
      <input readOnly name={props.DATname} id={props.DATid}
        className='login'
        value={value === 'Dec-31-2015' ? ' ' : value} ref={ref} />
      <label id={props.laDatname} className='label-log' htmlFor={props.DATname}>Birth date <span style={{ color: "red" }}>*</span></label>
    </div>
  ));
  return (<>
    {props.used === 'reg' && <DatePicker
      selected={startDate}
      onChange={(date) => { setStartDate(date); selDateHandler('userBdate', date); }}
      customInput={<ExampleCustomInput />}
      popperPlacement="bottom-end"
      dateFormat="MMM-dd-yyyy"
      showYearDropdown
      showMonthDropdown
      fixedHeight
      dateFormatCalendar="MMMM"
      scrollableYearDropdown
      yearDropdownItemNumber={10}
      dropdownMode="select"
      maxDate={maxDate}
      popperModifiers={[
        {
          name: "offset",
          options: {
            offset: [-35, -20],
          },
        },
        {
          name: "preventOverflow",
          options: {
            rootBoundary: "viewport",
            tether: false,
            altAxis: true,
          },
        },
      ]}
    />}
    {/* {props.used === 'ban' && <DatePicker 
      selected={startDate}
      onChange={(date) => {setStartDate(date); setDateChanged(date);}}
      customInput={<ExampleCustomInput />}
      popperPlacement="bottom-end"
      showYearDropdown
      showMonthDropdown
      showTimeSelect
      dateFormatCalendar="MMMM"
      timeFormat="HH:mm"
      timeIntervals={60}
      timeCaption="time"
      dateFormat="MMMM d, yyyy hh:mm aa"
      scrollableYearDropdown
      dropdownMode="select"
      popperModifiers={[
        {
          name: "offset",
          options: {
            offset: [-35, -20],
          },
        },
        {
          name: "preventOverflow",
          options: {
            rootBoundary: "viewport",
            tether: false,
            altAxis: true,
          },
        },
      ]} 
      />} */}

  </>)
}

export default DateComp