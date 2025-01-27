vcl 4.1;

import std;

backend default {
    .host = "app";
    .port = "8000";
}

sub vcl_backend_response {
    if (beresp.http.Set-Cookie && beresp.status == 200) {
        std.collect(beresp.http.Set-Cookie); # merge multiple set cookies into one
        set beresp.http.first-visit = beresp.http.Set-Cookie;
        unset beresp.http.Set-Cookie;
    }
}

sub vcl_deliver
{
    # Insert Diagnostic header to show Hit or Miss
    if (obj.hits > 0) {
        set resp.http.X-Cache = "HIT";
        set resp.http.X-Cache-Hits = obj.hits;
    }
    else {
        set resp.http.X-Cache = "MISS";
    }

    # Re-create the cookie again and remove the temporary header
    if (resp.http.first-visit) {
        set resp.http.Set-Cookie = resp.http.first-visit;
        unset resp.http.first-visit;
    }

    # Remove flag
    unset resp.http.Varnish-Cache;
}

sub vcl_recv {
    # https://www.varnish-software.com/developers/tutorials/removing-cookies-varnish/#only-keep-required-cookies
    if (req.http.Cookie) {
        set req.http.Cookie = ";" + req.http.Cookie;
        set req.http.Cookie = regsuball(req.http.Cookie, "; +", ";");
        set req.http.Cookie = regsuball(req.http.Cookie, ";([sS]ession|Token)=", "; \1=");
        set req.http.Cookie = regsuball(req.http.Cookie, ";[^ ][^;]*", "");
        set req.http.Cookie = regsuball(req.http.Cookie, "^[; ]+|[; ]+$", "");

        if (req.http.cookie ~ "^\s*$") {
            unset req.http.cookie;
        }
    }

    # Flag varnish request
    set req.http.Varnish-Cache = 1;
}
