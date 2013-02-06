var templates={"deals":"<div class=\"row\" id=\"staggered\"><% _.each(deals, function(deal) { %><div class=\"columns staggered-item\"><div class=\"tile\"><% if (typeof deal.HappyHour != 'undefined') { %><a href=\"<%= unlokt.settings.webroot %>spots\/view\/<%= deal.Spot.id %>\"><img src=\"<% print(unlokt.helpers.gen_path('spot', deal.Spot.id, 223, 223, deal.Spot.image_name)); %>\"><\/a><% } else if (typeof deal.Deal == 'undefined') { %><a href=\"<%= unlokt.settings.webroot %>spots\/view\/<%= deal.Spot.id %>\"><img src=\"<% print(unlokt.helpers.gen_path('spot', deal.Spot.id, 223, 223, deal.Spot.image_name)); %>\"><\/a><% } else if (deal.Deal.keys == 0) { %><a href=\"<%= unlokt.settings.webroot %>deals\/view\/<%= deal.Deal.id %>\"><img src=\"<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223, 223, deal.Deal.image_name)); %>\"><\/a><% } else if (deal.Deal.keys == 1) { %><a href=\"<%= unlokt.settings.webroot %>deals\/view\/<%= deal.Deal.id %>\"><img src=\"<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223, 223, deal.Deal.image_name)); %>\"><\/a><% } else { %><a href=\"<%= unlokt.settings.webroot %>deals\/view\/<%= deal.Deal.id %>\"><img src=\"<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223, 223, deal.Deal.image_name)); %>\"><\/a><% } %> <%var now = new XDate();var todays_day = now.getDay(); \/* returns 0-6, day of the week.*\/if (typeof deal.HappyHour != 'undefined') {\/* Create a date so we can parse the time. Le Sigh. *\/var happy_hour_end_xdate = new XDate('2012-01-01 ' + deal.ParentHappyHour.end);var happy_hour_start_xdate = new XDate('2012-01-01 ' + deal.ParentHappyHour.start);\/* In this case, happy hour is currently happening *\/ %><div class=\"tile-footer\"><div class=\"tile-type\"><h4><i class=\"icon-clock-2\"><\/i><\/h4><h2><%= deal.Spot.name %><\/h2><\/div><div class=\"block-actions\"><div class=\"happy-hour\"><div class=\"title\"><p><%= deal.HappyHour.title %><span class=\"end-time-wrapper\"><b><span class=\"end-time\"><% print(happy_hour_start_xdate.toString('h:mm tt')); %><\/span> - <span class=\"end-time\"><% print(happy_hour_end_xdate.toString('h:mm tt')); %><\/span><\/b><\/span> <\/p><\/div><div class=\"is-active\"><%= deal.HappyHour.description %><\/div><\/div><a class=\"btn btn-red pull-right\" href=\"<%= unlokt.settings.webroot %>spots\/view\/<%= deal.Spot.id %>\">View Spot<\/a><\/div><\/div><% } else if (typeof deal.Deal == 'undefined') { %><div class=\"tile-footer\"><div class=\"tile-type\"><h4><i class=\"icon-location\"><\/i><\/h4><h2><%= deal.Spot.name %><\/h2><\/div><div class=\"block-actions\"><% if(_.indexOf(spot_ids_i_follow, parseInt(deal.Spot.id)) > -1) { %><a class=\"btn btn-blue pull-right following\" href=\"javascript:void(0);\" data-spot-id=\"<%= deal.Spot.id %>\">Unfollow Spot<\/a><% } else { %><a class=\"btn btn-red pull-right follow\" href=\"javascript:void(0);\" data-spot-id=\"<%= deal.Spot.id %>\">Follow Spot<\/a><% } %><\/div><\/div><% } else { %><div class=\"tile-footer\"><div class=\"tile-type\"><% if (deal.Deal.keys == '0') { %><h4><i class=\"icon-calendar\"><\/i><\/h4><% } else if (deal.Deal.keys == '1') { %><h4><i class=\"icon-tag-2\"><\/i><\/h4><% } else { %><h4><i class=\"icon-key\"><\/i><\/h4><% } %><h2><%= deal.Deal.name %><\/h2><\/div><div class=\"block-actions\"><% if(deal.Deal.keys == 0) { %><p><%var startDate = new XDate(deal.Deal.start_date);var today = new XDate();var displayDate = '';if(startDate < today){displayDate = today.toString('ddd d MMM');}else{displayDate = startDate.toString('ddd d MMM');}%><%= displayDate %><\/p><% } %><p><%= deal.Deal.description %><\/p><% if (deal.Deal.keys > 1) { %><span class=\"keys-total pull-left\"><%= deal.Deal.keys %><\/span><% } %><% if (deal.Deal.keys > 0) { %><a class=\"btn btn-red pull-right\" href=\"<%= unlokt.settings.webroot %>deals\/view\/<%= deal.Deal.id %>\">View Special<\/a><% } else { %><a class=\"btn btn-red pull-right\" href=\"<%= unlokt.settings.webroot %>deals\/view\/<%= deal.Deal.id %>\">View Event<\/a><% } %><\/div><\/div><% } %><\/div><\/div><% }); %><\/div><div class=\"row\"><a class=\"btn-tap\" href=\"javascript:search(<%= new_limit %>);\">Show More<\/a><\/div>","feeds":"<div class=\"block block-darkgray\"><h4><i class=\"icon-megaphone\"><\/i> Spot Feed<\/h4><% _.each(feeds, function(feed) { %><div class=\"feed-item\"><img src=\"<% print(unlokt.helpers.gen_path('spot', feed.Spot.id, 40, 40, feed.Spot.image_name)); %>\" class=\"pull-left\"><div class=\"attachments\"><% _.each(feed.Attachment, function(attachment) { %><img data-attachment-id=\"<%= attachment.id %>\" data-spot-id=\"<%= attachment.id %>\" src=\"<% print(unlokt.helpers.gen_path('attachment', attachment.id, 40, 40)); %>\"><% }); %><\/div><h3 class=\"title\"><a href=\"<%= unlokt.settings.webroot %>spots\/view\/<%= feed.Spot.id %>\"><%= h(feed.Spot.name) %><\/a><\/h3><div class=\"description\"><p><%= h(feed.Feed.feed) %><\/p><% if (typeof feed.Attachment !== 'undefined' && _.isArray(feed.Attachment) && feed.Attachment.length > 0) { %><% \/*End if*\/ } %><\/div><a class=\"more\" href=\"<%= unlokt.settings.webroot %>spots\/view\/<%= feed.Spot.id %>#feeds\" title=\"\">Read More<\/a><\/div><% }); %><\/div>","mod-add_deal_preview":"<h2><% if (deal.Deal.keys == 0) { %><h4><i class=\"icon-calendar\">Event<\/i><\/h4><% } else if (deal.Deal.keys == 1) { %><h4><i class=\"icon-tag-2\"><\/i> Special<\/h4><% } else { %><h4><i class=\"icon-key\"><\/i> Reward<\/h4><% } %><\/h2><div class=\"tile\"><img src=\"\/gen\/temp\/0\/270x270\/<%= deal.Deal.tmp_image_name %>\"><div class=\"tile-footer\"><div class=\"tile-type\"><% if (deal.Deal.keys == 0) { %><h4><i class=\"icon-calendar\"><\/i><\/h4><% } else if (deal.Deal.keys == 1) { %><h4><i class=\"icon-tag-2\"><\/i><\/h4><% } else { %><h4><i class=\"icon-key\"><\/i><\/h4><% } %><h2><%= h(deal.Deal.name) %><\/h2><\/div><div class=\"block-actions\"><p><%= h(deal.Deal.description) %><\/p><% if(deal.Deal.keys > 1) { %><span class=\"keys-total\"><%= deal.Deal.keys %><\/span><% } %><% if(deal.Deal.keys > 0) { %><a class=\"btn btn-red pull-right\" href=\"<%= unlokt.settings.webroot %>deals\/view\/<%= deal.Deal.id %>\">View Special<\/a><% } else { %><a class=\"btn btn-red pull-right\" href=\"<%= unlokt.settings.webroot %>deals\/view\/<%= deal.Deal.id %>\">View Event<\/a><% } %><\/div><\/div><\/div>","reviews":"<div class=\"block block-darkgray nh\"><h4><i class=\"icon-pencil\"><\/i>  Spot Notes<\/h4><\/div><div class=\"note-slider twelve\"><div class=\"block-slider-nav note-slider-nav\"><a class=\"left\" href=\"javascript:void(0);\"><\/a><a class=\"right\" href=\"javascript:void(0);\"><\/a><\/div><div class=\"note-slider-container review-wr\"><% _.each(reviews, function(review) { %><div class=\"note-slide columns\"><div class=\"review-item tile\"><div class=\"head\"><img src=\"<% print(unlokt.helpers.gen_path('user', review.Review.user_id, 40, 40, review.User.image_name)); %>\" class=\"pull-left\"><% if (review.Review.name) { %><h3 class=\"title\"><%= h(review.Review.name) %><\/h3><% } %><\/div><div><p class=\"description\"><%= h(review.Review.review) %><\/p><\/div><div class=\"note-actions\"><span class=\"review-spot\">Noted: <a href=\"<%= unlokt.settings.webroot %>spots\/view\/<%= review.Spot.id %>\"><%= h(review.Spot.name) %><\/a><\/span><a class=\"flag-icon\" href=\"javascript:void(0);\" data-flag-review=\"<%= review.Review.id %>\"> &#9873;<\/a><a class=\"more\" href=\"<%= unlokt.settings.webroot %>reviews\/view\/<%= h(review.Review.id) %>\">Read More<\/a><\/div><\/div><\/div><% }); %><\/div><\/div>"};