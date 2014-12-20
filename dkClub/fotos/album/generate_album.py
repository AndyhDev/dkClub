#!/usr/bin/env python
# -*- coding: utf-8 -*-

import os
import sys
import Image

def get_size(size, org_size):
    w1 = size[0]
    w2 = org_size[0]
    
    h1 = size[1]
    h2 = org_size[1]
    
    scale_w = ((100.0 / w2) * w1)
    scale_h = ((100.0 / h2) * h1)
    
    if scale_w > 100 and scale_h > 100:
        return org_size
    
    elif scale_w == scale_h:
        return size
    
    elif scale_w > scale_h:
        w1 = ((w2 / 100.0) * scale_h)
        return (int(w1), int(h1))
    
    elif scale_h > scale_w:
        h1 = ((h2 / 100.0) * scale_w)
        return (int(w1), int(h1))
    
if len(sys.argv) != 3:
    print "Falsche Parameter\n\t-Bilderordner\n\t-Albumname"
    sys.exit()
    
if not os.path.isdir(sys.argv[1]):
    print "Bilderordner ist kein Verzeichnis"
    
files = os.listdir(sys.argv[1])
album_path = os.path.join(sys.path[0], sys.argv[2])
if not os.path.isdir(album_path):
    os.mkdir(album_path)
    
for name in files:
    ext = os.path.splitext(name)[1].lower()
    if ext in [".jpg", ".jpeg", ".jpe", ".png", ".tiff"]:
        print "bearbeite Bild: ", name
        path = os.path.join(sys.argv[1], name)
        image = Image.open(path)
        thumb_size = get_size((120, 90), image.size)
        image_size = get_size((800, 600), image.size)
        print "SIZE1:", thumb_size
        thumb = image.resize(thumb_size, Image.ANTIALIAS)
        new_image = image.resize(image_size, Image.ANTIALIAS) 
        
        thumb.save(os.path.join(album_path, "thumb_" + name))
        new_image.save(os.path.join(album_path, name))
        
        
