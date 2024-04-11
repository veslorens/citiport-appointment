linkId = false;
if (appointmentId) {
    console.log("Appointment ID:", appointmentId);
    linkId = true;
} else {
    console.log("No appointment ID available.");
    linkId = false;
}

function emptyAll() {
    var modal = document.getElementById("emptyAll");
    modal.classList.add("show");
    modal.style.display = "block";
}

function closeEmptyAll() {
    var modal = document.getElementById("emptyAll");
    modal.classList.remove("show");
    modal.style.display = "none";
}

function emptyTimeSlots() {
    var modal = document.getElementById("emptyTimeSlots");
    modal.classList.add("show");
    modal.style.display = "block";
}

function closeEmptyTimeSlots() {
    var modal = document.getElementById("emptyTimeSlots");
    modal.classList.remove("show");
    modal.style.display = "none";
}

function emptyServiceDetails() {
    var modal = document.getElementById("emptyServiceDetails");
    modal.classList.add("show");
    modal.style.display = "block";
}

function closeEmptyServiceDetails() {
    var modal = document.getElementById("emptyServiceDetails");
    modal.classList.remove("show");
    modal.style.display = "none";
}

function confirmationOptions() {
    var modal = document.getElementById("confirmationOptions");
    modal.classList.add("show");
    modal.style.display = "block";
}

function closeConfirmationOptions() {
    var modal = document.getElementById("confirmationOptions");
    modal.classList.remove("show");
    modal.style.display = "none";
}

function success() {
    var modal = document.getElementById("success");
    modal.classList.add("show");
    modal.style.display = "block";
}

var workingDays = 10;
var slotsPerTime = 1;
var opening = 8;
var closing = 17;

var timeSlots = [];
for (var i = opening; i < closing; i++) {
    var start = (i < 10 ? "0" : "") + i + ":00";
    var end = (i < 10 ? "0" : "") + i + ":59";
    timeSlots.push({ start: start, end: end, count: slotsPerTime });
}

var countTimeSlots = timeSlots.length;
var slotsPerDay = slotsPerTime * countTimeSlots;

var datesArray = [];
for (var i = 0; datesArray.length < workingDays; i++) {
    var futureDate = new Date();
    futureDate.setDate(futureDate.getDate() + i);
    if (futureDate.getDay() !== 6 && futureDate.getDay() !== 0) {
        var formattedDate = futureDate.toISOString().slice(0, 10);
        datesArray.push([formattedDate, slotsPerDay]);
    }
}

var dateCounts = [];
var identifiedByCounts = [];
appointments.forEach(function (appointment) {
    var appointmentDate = new Date(appointment.booked_at);
    var formattedDate = appointmentDate.toISOString().slice(0, 10);

    var options = {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
    };

    var formattedDateTime = appointmentDate
        .toLocaleString("en-US", options)
        .replace(/\//g, "-")
        .replace(",", "");

    if (dateCounts.hasOwnProperty(formattedDate)) {
        dateCounts[formattedDate]++;
    } else {
        dateCounts[formattedDate] = 1;
    }

    identifiedByCounts[formattedDateTime] = appointmentDate;
});

Object.entries(dateCounts).forEach(([date, count]) => {
    dateCounts.push({ date, count });
});

var eventsArray = [];
for (var i = 0; i < datesArray.length; i++) {
    var date = datesArray[i][0];
    var count = datesArray[i][1];

    if (dateCounts.hasOwnProperty(date)) {
        count -= dateCounts[date];

        delete dateCounts[date];
    }
    eventsArray.push({
        title: count,
        start: date,
    });
}

document.addEventListener("DOMContentLoaded", function () {
    let firstNonZeroTitle = null;
    let firstNonZeroStart = null;

    eventsArray.forEach((event) => {
        if (event.title !== 0 && firstNonZeroTitle === null) {
            firstNonZeroTitle = event.title;
            firstNonZeroStart = event.start;
        }
        if (event.title === 0) {
            event.color = "red";
        }
    });

    const EarliestAvailableAppointment = document.getElementById(
        "EarliestAvailableAppointment"
    );
    if (firstNonZeroTitle !== null && firstNonZeroStart !== null) {
        EarliestAvailableAppointment.innerHTML = `Earliest available appointment: ${firstNonZeroStart}<br> Available lots: ${firstNonZeroTitle}`;
    }
});

var appointmentsArray = [];
for (var i = 0; i < appointments.length; i++) {
    var appointmentDate = new Date(appointments[i].booked_at);
    if (appointmentDate > -new Date()) {
        appointmentsArray.push(appointments[i]);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let previousClickedEvent = null;
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        events: eventsArray,

        eventClick: function (info) {
            if (previousClickedEvent) {
                previousClickedEvent.style.backgroundColor = "";
            }
            info.el.style.backgroundColor = "#6CB4EE";
            previousClickedEvent = info.el;
            timeSlots.forEach((slot) => {
                slot.count = slotsPerTime;
            });
            formattedDate = `${info.event.start.getFullYear()}-${(
                info.event.start.getMonth() + 1
            )
                .toString()
                .padStart(2, "0")}-${info.event.start
                .getDate()
                .toString()
                .padStart(2, "0")}`;
            var matchingAppointments = [];
            appointmentsArray.forEach(function (appointment) {
                var bookedDate = appointment.booked_at.split(" ")[0];
                if (bookedDate === formattedDate) {
                    matchingAppointments.push(appointment);
                }
            });

            function isTimeInRange(time, start, end) {
                return time >= start && time <= end;
            }

            matchingAppointments.forEach((appointment) => {
                var bookedTime = new Date(appointment.booked_at);
                var bookedTimeString =
                    ("0" + bookedTime.getHours()).slice(-2) +
                    ":" +
                    ("0" + bookedTime.getMinutes()).slice(-2) +
                    ":" +
                    ("0" + bookedTime.getSeconds()).slice(-2);

                timeSlots.forEach((slot) => {
                    if (isTimeInRange(bookedTimeString, slot.start, slot.end)) {
                        slot.count -= 1;
                    }
                });
            });

            var formContainer = document.getElementById("radioForm");
            formContainer.innerHTML = "";
            timeSlots.forEach(function (slot) {
                var input = document.createElement("input");
                input.setAttribute("type", "radio");
                input.setAttribute("name", "timeSlot");
                input.setAttribute("value", slot.start);
                var label = document.createElement("label");

                if (slot.count === 0 || slot.count < 0) {
                    label.textContent =
                        "\u00A0" +
                        slot.start +
                        " - " +
                        slot.end +
                        "\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0" +
                        " Fully Booked: " +
                        "\u00A0\u00A0\u00A0" +
                        slot.count;
                    label.style.color = "red";
                    label.style.fontSize = "16px";
                    label.style.fontWeight = "bold";
                    input.setAttribute("disabled", "disabled");
                } else {
                    input.addEventListener("click", function () {
                        selectedRadioValue = this.value;
                        booked_at = formattedDate + " " + selectedRadioValue;
                    });
                    label.textContent =
                        "\u00A0" +
                        slot.start +
                        " - " +
                        slot.end +
                        "\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0\u00A0" +
                        " Available Slots: " +
                        slot.count;
                    label.style.color = "green";
                    label.style.fontSize = "16px";
                    label.style.fontWeight = "bold";
                }
                input.style.marginRight = "5px";
                input.style.marginBottom = "15px";
                label.insertBefore(input, label.firstChild);
                formContainer.appendChild(label);
                formContainer.appendChild(document.createElement("br"));
            });

            // Add media query for mobile devices
            if (window.matchMedia("(max-width: 768px)").matches) {
                var labels = document.querySelectorAll("label");
                labels.forEach(function (label) {
                    label.style.fontSize = "11px";
                });
            }

            var submitButton = document.createElement("input");
            submitButton.setAttribute("type", "button");
            submitButton.setAttribute("value", "Submit");
            submitButton.addEventListener("click", function () {
                var csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");
                var service_name =
                    document.getElementById("service_name").value;
                var service_type =
                    document.getElementById("service_type").value;
                var office = document.getElementById("office").value;

                var selectedRadioButton = document.querySelector(
                    'input[name="timeSlot"]:checked'
                );

                function resetBackgroundColor(elementId) {
                    var element = document.getElementById(elementId);
                    if (element) {
                        element.style.backgroundColor = "";
                    }
                }

                document
                    .getElementById("service_name")
                    .addEventListener("change", function () {
                        resetBackgroundColor("service_name");
                    });
                document
                    .getElementById("service_type")
                    .addEventListener("change", function () {
                        resetBackgroundColor("service_type");
                    });
                document
                    .getElementById("office")
                    .addEventListener("change", function () {
                        resetBackgroundColor("office");
                    });
                document
                    .querySelectorAll('input[name="timeSlot"]')
                    .forEach(function (radio) {
                        radio.addEventListener("change", function () {
                            resetBackgroundColor(radio.id);
                        });
                    });

                if (
                    (!service_name || !service_type || !office) &&
                    !selectedRadioButton
                ) {
                    emptyAll();
                } else if (
                    !selectedRadioButton &&
                    service_name &&
                    service_type &&
                    office
                ) {
                    emptyTimeSlots();
                } else if (
                    selectedRadioButton &&
                    (!service_name || !service_type || !office)
                ) {
                    emptyServiceDetails();
                } else {
                    confirmationOptions();

                    document
                        .getElementById("confirmationOptions")
                        .addEventListener("click", function () {
                            if (confirm) {
                                var xhr = new XMLHttpRequest();

                                if (linkId === false) {
                                    xhr.open(
                                        "POST",
                                        "/appointment/store",
                                        true
                                    );
                                } else if (linkId === true) {
                                    xhr.open(
                                        "POST",
                                        `/appointment/${appointmentId}/update`,
                                        true
                                    );
                                }
                                xhr.setRequestHeader(
                                    "Content-Type",
                                    "application/json"
                                );
                                xhr.setRequestHeader("X-CSRF-Token", csrfToken);
                                xhr.onload = function () {
                                    if (xhr.status >= 200 && xhr.status < 300) {
                                        setTimeout(function () {
                                            closeConfirmationOptions();
                                            success();
                                            setTimeout(function () {
                                                window.location.reload();
                                            }, 3000);
                                        });
                                    } else {
                                        console.error(
                                            "Failed to store appointment data"
                                        );
                                    }
                                };
                                xhr.onerror = function () {
                                    console.error("Network error occurred");
                                };

                                xhr.send(
                                    JSON.stringify({
                                        booked_at: booked_at,
                                        service_name: service_name,
                                        service_type: service_type,
                                        office: office,
                                    })
                                );
                            }
                        });
                }
            });
            submitButton.style.cssText =
                "background-color: #4fffb0; color: white; font-weight: bold; padding: 10px 20px; border: none; border-radius: 5px; width: 90%; cursor: pointer;";
            formContainer.appendChild(submitButton);
        },
    });
    calendar.render();
});
