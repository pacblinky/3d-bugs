function validateReport(data) {
  const message = $("#message");
  message.removeClass("alert-success").addClass("alert-danger");
  let valid = false;

  if (data.map_name === "" || data.entity_id === "" || data.title === "" || data.steps === "" || data.expected === "" || data.actual === "") {
    message.text("Fill out required empty fields");
    message.show();
  }
  else {
    if (isNaN(data.entity_id)) {
      message.text("You have enterned a invalid Entity ID");
      message.show();
    }
    else if (data.attachments !== "") {
      const types = ["jpg", "gif", "png","apng","jpeg","mp4", "webm", "ogg"];
      const links = data.attachments.toLowerCase().trim().split(/[\s|\n]+/);
      for (let i = 0; i < links.length; i++) {
        try {
          links[i] = new URL(links[i]);
          if(types.includes(links[i].pathname.split(".")[1]) || links[i].host == "youtube")
          {
            message.hide();
            message.removeClass("alert-danger").addClass("alert-success");
            valid = true;
          }
          else
          {
            message.removeClass("alert-success").addClass("alert-danger");
            message.text("You have enterned invalid attachments");
            message.show();
            valid = false;
          }
        }
        catch (e) {
          valid = false;
          message.removeClass("alert-success").addClass("alert-danger");
          message.text("You have enterned invalid attachments");
          message.show();
          break;
        }
      }
    }
    else {
      message.hide();
      message.removeClass("alert-danger").addClass("alert-success");
      valid = true;
    }
  }
  return valid;
}

$("#new_report").on("submit",function (event) {
  event.preventDefault();
  const data = Object.fromEntries($(this).serializeArray().map(({ name, value }) => [name, value]));
  data["action"] = "new_report";
  if (validateReport(data)) {
    $.post("../ajax.php", data)
      .done(function (data) {
        data = JSON.parse(data);
        document.getElementById("new_report").reset();
        const message = $("#message");
        message.html('Your report was successfuly created <a href="' + window.location.origin + '/reports/?report=' + data.report_id + '">here</a>');
        message.show();
      })
  }
})

function editMenu(id) {
  $("#edit").modal("show");
  $("#edit_title").text("Edit Report #" + id);
  $.post("../ajax.php", { report_id: id, action: "get_report" })
    .done(function (data) {
      data = JSON.parse(data);
      $("#map_name").val(data.map_name);
      $("#entity_id").val(data.entity_id);
      $("#title").val(data.title);
      $("#steps").val(data.steps);
      $("#expected").val(data.expected);
      $("#actual").val(data.actual);
      $("#attachments").val(data.attachments);
      $("#id").val(data.report_id);
    });
}

function deleteMenu(id) {
  $("#reason").val("");
  $("#delete").modal("show");
  $("#delete_title").text("Delete Report #" + id);
  $("#report_id").val(id);
}

$("#delete_report").on("submit",function (event) {
  event.preventDefault();
  const data = Object.fromEntries($(this).serializeArray().map(({ name, value }) => [name, value]));
  data["action"] = "delete_report";
  $.post("../ajax.php", data);
  $("#" + data.report_id).remove();
  $("#delete").modal("hide");
  if(window.location.href === window.location.origin + '/reports/?report=' + data.report_id)
  {
    window.location.replace(location.origin);
  }
})

$("#edit_report").on("submit",function (event) {
  event.preventDefault();
  const data = Object.fromEntries($(this).serializeArray().map(({ name, value }) => [name, value]));
  data["action"] = "edit_report";
  if (validateReport(data)) {
    $.post("../ajax.php", data)
      .done(function () {
        const selector = $("#" + data.report_id).find("[data-target=attachments]");
        if (data.attachments !== "") {
          selector.empty();
          $("#" + data.report_id).find("#attachment").show();
          const links = attachments.value.toLowerCase().trim().split(/[\s|\n]+/);
          for (let i = 0; i < links.length; i++) {
            selector.append('<a class="text-decoration-none" target="_blank" href="' + links[i] + '">' + links[i] + '</a>\n');
          }
        }
        else { $("#" + data.report_id).find("#attachment").hide(); selector.empty(); }
        $("#" + data.report_id).find("[data-target=map]").text(data.map_name + " #" + data.entity_id);
        $("#" + data.report_id).find("[data-target=title]").text(data.title);
        $("#" + data.report_id).find("[data-target=steps]").text(data.steps);
        $("#" + data.report_id).find("[data-target=expected]").text(data.expected);
        $("#" + data.report_id).find("[data-target=actual]").text(data.actual);
        $("#edit").modal("hide");
      });
  }
})
